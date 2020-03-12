<?php
namespace Ecommerce\Rest\Action\Payment;

use Ecommerce\Db\Transaction\Saver as TransactionEntitySaver;
use Ecommerce\Payment\MethodHandler\HandleCallbackData;
use Ecommerce\Payment\MethodHandler\Provider as MethodHandlerProvider;
use Ecommerce\Payment\ReturnUrl\GetData;
use Ecommerce\Payment\ReturnUrl\Provider as ReturnUrlProvider;
use Ecommerce\Rest\Action\Base;
use Ecommerce\Rest\Action\LoginExempt;
use Ecommerce\Transaction\Provider as TransactionProvider;
use Exception;
use Log\Log;

class Callback extends Base implements LoginExempt
{
	const METHOD = 'method';
	const TYPE   = 'type';

	/**
	 * @var TransactionProvider
	 */
	private $transactionProvider;

	/**
	 * @var MethodHandlerProvider
	 */
	private $methodHandlerProvider;

	/**
	 * @var TransactionEntitySaver
	 */
	private $transactionEntitySaver;

	/**
	 * @var ReturnUrlProvider
	 */
	private $returnUrlProvider;

	/**
	 * @param TransactionProvider $transactionProvider
	 * @param MethodHandlerProvider $methodHandlerProvider
	 * @param TransactionEntitySaver $transactionEntitySaver
	 * @param ReturnUrlProvider $returnUrlProvider
	 */
	public function __construct(
		TransactionProvider $transactionProvider,
		MethodHandlerProvider $methodHandlerProvider,
		TransactionEntitySaver $transactionEntitySaver,
		ReturnUrlProvider $returnUrlProvider
	)
	{
		$this->transactionProvider    = $transactionProvider;
		$this->methodHandlerProvider  = $methodHandlerProvider;
		$this->transactionEntitySaver = $transactionEntitySaver;
		$this->returnUrlProvider      = $returnUrlProvider;
	}

	/**
	 * @throws Exception
	 */
	public function executeAction()
	{
		$transaction = $this->transactionProvider->byId(
			$this
				->params()
				->fromRoute('transactionId')
		);

		if (!$transaction)
		{
			$this->getResponse()->setStatusCode(400);

			return $this->getResponse();
		}

		$type = $this
			->params()
			->fromRoute(self::TYPE);

		$methodHandler = $this->methodHandlerProvider->getHandler(
			$transaction->getPaymentMethod()
		);

		$handleCallbackResult = $methodHandler->handleCallback(
			HandleCallbackData::create()
				->setTransaction($transaction)
				->setType($type)
				->setRequest($this->getRequest())
		);

		$transactionEntity = $transaction->getEntity();
		$transactionEntity->setStatus($handleCallbackResult->getTransactionStatus());

		if (($foreignId = $handleCallbackResult->getForeignId()))
		{
			$transactionEntity->setForeignId($foreignId);
		}

		try
		{
			$this->transactionEntitySaver->save($transactionEntity);
		}
		catch (Exception $ex)
		{
			Log::error($ex);
		}

		$customer = $transaction->getCustomer();

		return $this
			->redirect()
			->toUrl(
				$this->returnUrlProvider->get(
					GetData::create()
						->setLocale($customer->getLocale())
						->setCallbackType($type)
				)
			);
	}
}