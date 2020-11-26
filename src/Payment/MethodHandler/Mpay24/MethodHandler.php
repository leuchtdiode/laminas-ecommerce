<?php
namespace Ecommerce\Payment\MethodHandler\Mpay24;

use AsyncQueue\Queue\AddData as AsyncQueueAddData;
use AsyncQueue\Queue\Adder as AsyncQueueAdder;
use Ecommerce\Common\UrlProvider;
use Ecommerce\Payment\CallbackType;
use Ecommerce\Payment\Method;
use Ecommerce\Payment\MethodHandler\HandleCallbackData;
use Ecommerce\Payment\MethodHandler\HandleCallbackResult;
use Ecommerce\Payment\MethodHandler\InitData;
use Ecommerce\Payment\MethodHandler\InitResult;
use Ecommerce\Payment\MethodHandler\MethodHandler as MethodHandlerInterface;
use Ecommerce\Transaction\Provider;
use Ecommerce\Transaction\SaveData;
use Ecommerce\Transaction\Saver;
use Ecommerce\Transaction\Status;
use Exception;
use Log\Log;
use Mpay24\Mpay24;
use Mpay24\Mpay24Order;

class MethodHandler implements MethodHandlerInterface
{
	/**
	 * @var array
	 */
	private $config;

	/**
	 * @var Saver
	 */
	private $saver;

	/**
	 * @var UrlProvider
	 */
	private $urlProvider;

	/**
	 * @var Provider
	 */
	private $transactionProvider;

	/**
	 * @var AsyncQueueAdder
	 */
	private $asyncQueueAdder;

	/**
	 * @param array $config
	 * @param Saver $saver
	 * @param UrlProvider $urlProvider
	 * @param Provider $transactionProvider
	 * @param AsyncQueueAdder $asyncQueueAdder
	 */
	public function __construct(
		array $config,
		Saver $saver,
		UrlProvider $urlProvider,
		Provider $transactionProvider,
		AsyncQueueAdder $asyncQueueAdder
	)
	{
		$this->config              = $config;
		$this->saver               = $saver;
		$this->urlProvider         = $urlProvider;
		$this->transactionProvider = $transactionProvider;
		$this->asyncQueueAdder     = $asyncQueueAdder;
	}

	/**
	 * @param InitData $data
	 * @return InitResult
	 * @throws Exception
	 */
	public function init(InitData $data): InitResult
	{
		$initResult = new InitResult();
		$initResult->setSuccess(false);

		if (!class_exists('Mpay24\Mpay24'))
		{
			throw new Exception('Class Mpay24\Mpay24 does not exist, please install with composer');
		}

		$transaction = $data->getTransaction();

		$saveResult = $this->saver->save(
			SaveData::create()
				->setTransaction($transaction = $data->getTransaction())
				->setStatus(Status::PENDING)
		);

		if (!$saveResult->isSuccess())
		{
			$initResult->setErrors($saveResult->getErrors());

			return $initResult;
		}

		// reload transaction
		$transaction = $this->transactionProvider->byId(
			$transaction->getId()
		);

		$transactionId = $transaction->getId();

		$mpay24 = $this->buildClient();

		$mdxi                      = new Mpay24Order();
		$mdxi->Order->Tid          = $transaction->getReferenceNumber();
		$mdxi->Order->Price        = $transaction
				->getTotalPrice()
				->getGross() / 100;
		$mdxi->Order->URL->Success = $this->getUrl(CallbackType::SUCCESS, $transactionId);
		$mdxi->Order->URL->Error   = $this->getUrl(CallbackType::ERROR, $transactionId);

		$paymentPage = $mpay24->paymentPage($mdxi);

		if (!$paymentPage->hasStatusOk())
		{
			Log::error($paymentPage->getStatus() . ' - ' . $paymentPage->getReturnCode() . ' - ' . $paymentPage->getErrText());

			return $initResult;
		}

		$initResult->setSuccess(true);
		$initResult->setRedirectUrl(
			$mpay24
				->paymentPage($mdxi)
				->getLocation()
		);

		return $initResult;
	}

	/**
	 * @param HandleCallbackData $data
	 * @return HandleCallbackResult
	 */
	public function handleCallback(HandleCallbackData $data): HandleCallbackResult
	{
		$result = new HandleCallbackResult();
		$result->setTransactionStatus(Status::PENDING);

		$transaction = $data->getTransaction();

		$query = $data
			->getRequest()
			->getQuery();

		Log::debug('Callback data: ' . var_export($query->toArray(), true));

		$transactionRefNumber = $query->get('TID');

		if ($transaction->getReferenceNumber() !== $transactionRefNumber)
		{
			return $result;
		}

		$transactionStatus = $transaction->getStatus();

		if (!$transactionStatus->isPending())
		{
			return $result;
		}

		$mpay24 = $this->buildClient();

		$paymentStatus = $mpay24->paymentStatusByTid($transaction->getReferenceNumber());

		Log::debug(var_export($paymentStatus, true));

		// abort right now if cancelled
		if ($paymentStatus->getStatus() === 'OK')
		{
			$mpay24TransactionStatus = $paymentStatus
				->getParam('STATUS');

			if ($mpay24TransactionStatus === 'REVERSED')
			{
				$result->setTransactionStatus(Status::CANCELLED);

				return $result;
			}
		}

		$this->asyncQueueAdder->add(
			AsyncQueueAddData::create()
				->setType(PendingCheckProcessor::ID)
				->setPayLoad(
					[
						'transactionId' => $transaction
							->getId()
							->toString(),
					]
				)
		);

		return $result;
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

	/**
	 * @param string $type
	 * @param string $transactionId
	 * @return string $type
	 */
	private function getUrl($type, $transactionId)
	{
		return $this->urlProvider->get(
			'ecommerce/payment/callback',
			[
				'transactionId' => $transactionId,
				'method'        => Method::MPAY_24,
				'type'          => $type,
			]
		);
	}
}