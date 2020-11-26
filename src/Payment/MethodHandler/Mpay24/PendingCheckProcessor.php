<?php
namespace Ecommerce\Payment\MethodHandler\Mpay24;

use AsyncQueue\Item\ProcessData;
use AsyncQueue\Item\Processor;
use AsyncQueue\Item\ProcessResult;
use Ecommerce\Db\Transaction\Entity;
use Ecommerce\Db\Transaction\Saver as TransactionEntitySaver;
use Ecommerce\Payment\Method;
use Ecommerce\Payment\PostPayment\Handler as PostPaymentHandler;
use Ecommerce\Payment\PostPayment\SuccessfulData;
use Ecommerce\Payment\PostPayment\UnsuccessfulData;
use Ecommerce\Transaction\Provider as TransactionProvider;
use Ecommerce\Transaction\Status;
use Exception;
use Log\Log;
use Mpay24\Mpay24;

class PendingCheckProcessor implements Processor
{
	const ID = 'mpay24PendingCheck';

	/**
	 * @var array
	 */
	private $config;

	/**
	 * @var TransactionProvider
	 */
	private $transactionProvider;

	/**
	 * @var TransactionEntitySaver
	 */
	private $transactionEntitySaver;

	/**
	 * @var PostPaymentHandler
	 */
	private $postPaymentHandler;

	/**
	 * @param array $config
	 * @param TransactionProvider $transactionProvider
	 * @param TransactionEntitySaver $transactionEntitySaver
	 * @param PostPaymentHandler $postPaymentHandler
	 */
	public function __construct(
		array $config,
		TransactionProvider $transactionProvider,
		TransactionEntitySaver $transactionEntitySaver,
		PostPaymentHandler $postPaymentHandler
	)
	{
		$this->config                 = $config;
		$this->transactionProvider    = $transactionProvider;
		$this->transactionEntitySaver = $transactionEntitySaver;
		$this->postPaymentHandler     = $postPaymentHandler;
	}

	/**
	 * @param ProcessData $data
	 * @return ProcessResult
	 */
	public function process(ProcessData $data)
	{
		$result = new ProcessResult();

		try
		{
			$transactionId = $data->getPayLoad()['transactionId'];

			$transaction = $this->transactionProvider->byId($transactionId);

			if (!$transaction)
			{
				$result->setSuccess(false);

				return $result;
			}

			$transactionStatus = $transaction->getStatus();

			if (!$transactionStatus->isPending())
			{
				$result->setSuccess(false);

				return $result;
			}

			$transactionEntity = $transaction->getEntity();

			$mpay24 = $this->buildClient();

			$paymentStatus = $mpay24->paymentStatusByTid($transaction->getReferenceNumber());

			Log::debug(var_export($paymentStatus, true));

			if ($paymentStatus->getStatus() !== 'OK')
			{
				$this->postPaymentHandler->unsuccessful(
					UnsuccessfulData::create()
						->setTransaction($data->getTransaction())
				);

				return $result;
			}

			$transactionEntity->setForeignId($paymentStatus->getParam('MPAYTID'));

			$this->transactionEntitySaver->save($transactionEntity);

			$mpay24TransactionStatus = $paymentStatus
				->getParam('STATUS');

			if (in_array($mpay24TransactionStatus, [ 'BILLED', 'RESERVED' ]))
			{
				$this->postPaymentHandler->successful(
					SuccessfulData::create()
						->setTransaction($transaction)
				);

				$this->setStatus($transactionEntity, Status::SUCCESS);

				$result->setSuccess(true);

				return $result;
			}

			if (in_array($mpay24TransactionStatus, [ 'REVERSED' ]))
			{
				$this->setStatus($transactionEntity, Status::CANCELLED);

				$result->setSuccess(true);

				return $result;
			}

			$this->postPaymentHandler->unsuccessful(
				UnsuccessfulData::create()
					->setTransaction($transaction)
			);

			$this->setStatus($transactionEntity, Status::ERROR);

			$result->setSuccess(true);
		}
		catch (Exception $ex)
		{
			Log::error($ex);

			$result->setSuccess(false);
		}

		return $result;
	}

	/**
	 * @param Entity $entity
	 * @param string $status
	 * @throws Exception
	 */
	private function setStatus(Entity $entity, string $status)
	{
		$entity->setStatus($status);

		$this->transactionEntitySaver->save($entity);
	}

	/**
	 * @return Mpay24
	 */
	private function buildClient()
	{
		$options = $this->getOptions();

		return new Mpay24($options['merchantId'], $options['soapPassword'], $options['sandbox']);
	}

	/**
	 * @return array
	 */
	private function getOptions()
	{
		return $this->config['ecommerce']['payment']['method'][Method::MPAY_24]['options'];
	}
}