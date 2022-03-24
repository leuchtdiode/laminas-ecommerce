<?php
namespace Ecommerce\Payment\MethodHandler\Mpay24;

use Ecommerce\Common\UrlProvider;
use Ecommerce\Payment\CallbackType;
use Ecommerce\Payment\Method;
use Ecommerce\Payment\MethodHandler\HandleCallbackData;
use Ecommerce\Payment\MethodHandler\HandleCallbackResult;
use Ecommerce\Payment\MethodHandler\InitData;
use Ecommerce\Payment\MethodHandler\InitResult;
use Ecommerce\Payment\MethodHandler\MethodHandler as MethodHandlerInterface;
use Ecommerce\Payment\PostPayment\Handler as PostPaymentHandler;
use Ecommerce\Payment\PostPayment\SuccessfulData;
use Ecommerce\Payment\PostPayment\UnsuccessfulData;
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
	private array $config;

	private Saver $saver;

	private UrlProvider $urlProvider;

	private Provider $transactionProvider;

	private PostPaymentHandler $postPaymentHandler;

	public function __construct(
		array $config,
		Saver $saver,
		UrlProvider $urlProvider,
		Provider $transactionProvider,
		PostPaymentHandler $postPaymentHandler
	)
	{
		$this->config              = $config;
		$this->saver               = $saver;
		$this->urlProvider         = $urlProvider;
		$this->transactionProvider = $transactionProvider;
		$this->postPaymentHandler  = $postPaymentHandler;
	}

	/**
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

		$mdxi                           = new Mpay24Order();
		$mdxi->Order->Tid               = $transaction->getReferenceNumber();
		$mdxi->Order->Price             = $transaction
				->getTotalPrice()
				->getGross() / 100;
		$mdxi->Order->URL->Success      = $this->getUrl(CallbackType::SUCCESS, $transactionId);
		$mdxi->Order->URL->Error        = $this->getUrl(CallbackType::ERROR, $transactionId);
		$mdxi->Order->URL->Confirmation = $this->getUrl(CallbackType::CONFIRMATION, $transactionId);

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

	public function handleCallback(HandleCallbackData $data): HandleCallbackResult
	{
		$result = new HandleCallbackResult();
		$result->setTransactionStatus(Status::PENDING);

		$isConfirmation    = $data->getType() === CallbackType::CONFIRMATION;
		$transaction       = $data->getTransaction();
		$transactionStatus = $transaction->getStatus();

		$result->setRedirect(!$isConfirmation);

		// leave status as be if not pending
		if (!$transactionStatus->isPending())
		{
			$result->setTransactionStatus(
				$transaction
					->getStatus()
					->getId()
			);

			return $result;
		}

		// return as pending if this is not the confirmation (could be success/error as well)
		if (!$isConfirmation)
		{
			return $result;
		}

		$query = $data
			->getRequest()
			->getQuery();

		Log::debug('Callback data: ' . var_export($query->toArray(), true));

		$transactionRefNumber = $query->get('TID');

		if ($transaction->getReferenceNumber() !== $transactionRefNumber)
		{
			return $result;
		}

		$mpay24 = $this->buildClient();

		$paymentStatus = $mpay24->paymentStatusByTid($transaction->getReferenceNumber());

		Log::debug(var_export($paymentStatus, true));

		if ($paymentStatus->getStatus() !== 'OK')
		{
			$result->setTransactionStatus(Status::ERROR);

			$this->postPaymentHandler->unsuccessful(
				UnsuccessfulData::create()
					->setTransaction($transaction)
			);

			return $result;
		}

		$result->setForeignId($paymentStatus->getParam('MPAYTID'));

		$mpay24TransactionStatus = $paymentStatus
			->getParam('STATUS');

		if (in_array($mpay24TransactionStatus, [ 'BILLED', 'RESERVED' ]))
		{
			$this->postPaymentHandler->successful(
				SuccessfulData::create()
					->setTransaction($transaction)
			);

			$result->setTransactionStatus(Status::SUCCESS);

			return $result;
		}

		if ($mpay24TransactionStatus == 'REVERSED')
		{
			$result->setTransactionStatus(Status::CANCELLED);

			return $result;
		}

		$this->postPaymentHandler->unsuccessful(
			UnsuccessfulData::create()
				->setTransaction($transaction)
		);

		$result->setTransactionStatus(Status::ERROR);

		return $result;
	}

	private function buildClient(): Mpay24
	{
		$options = $this->getOptions();

		return new Mpay24($options['merchantId'], $options['soapPassword'], $options['sandbox']);
	}

	private function getOptions(): array
	{
		return $this->config['ecommerce']['payment']['method'][Method::MPAY_24]['options'];
	}

	private function getUrl(string $type, string $transactionId): string
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