<?php
namespace Ecommerce\Payment\MethodHandler\PayPal;

use AsyncQueue\Queue\AddData as AsyncQueueAddData;
use AsyncQueue\Queue\Adder as AsyncQueueAdder;
use Common\Translator;
use Ecommerce\Common\UrlProvider;
use Ecommerce\Payment\CallbackType;
use Ecommerce\Payment\Method;
use Ecommerce\Payment\MethodHandler\HandleCallbackData;
use Ecommerce\Payment\MethodHandler\HandleCallbackResult;
use Ecommerce\Payment\MethodHandler\InitData;
use Ecommerce\Payment\MethodHandler\InitResult;
use Ecommerce\Payment\MethodHandler\MethodHandler as MethodHandlerInterface;
use Ecommerce\Transaction\Status;
use Exception;
use Log\Log;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction as PayPalTransaction;

class MethodHandler implements MethodHandlerInterface
{
	/**
	 * @var array
	 */
	private $config;

	/**
	 * @var UrlProvider
	 */
	private $urlProvider;

	/**
	 * @var AsyncQueueAdder
	 */
	private $asyncQueueAdder;

	/**
	 * @var Api
	 */
	private $api;

	/**
	 * @var InitData
	 */
	private $data;

	/**
	 * @param array $config
	 * @param UrlProvider $urlProvider
	 * @param AsyncQueueAdder $asyncQueueAdder
	 * @param Api $api
	 */
	public function __construct(array $config, UrlProvider $urlProvider, AsyncQueueAdder $asyncQueueAdder, Api $api)
	{
		$this->config          = $config;
		$this->urlProvider     = $urlProvider;
		$this->asyncQueueAdder = $asyncQueueAdder;
		$this->api             = $api;
	}

	/**
	 * @param InitData $data
	 * @return InitResult
	 */
	public function init(InitData $data): InitResult
	{
		$this->data = $data;

		$result = new InitResult();
		$result->setSuccess(false);

		$payment = $this->createPayPalPayment();

		try
		{
			$payment->create($this->api);

			$approvalUrl = $payment->getApprovalLink();

			$result->setSuccess(true);
			$result->setRedirectUrl($approvalUrl);

			return $result;

		}
		catch (Exception $ex)
		{
			Log::error($ex);
		}

		return $result;
	}

	/**
	 * @param HandleCallbackData $data
	 * @return HandleCallbackResult
	 */
	public function handleCallback(HandleCallbackData $data): HandleCallbackResult
	{
		$request = $data->getRequest();

		$result = new HandleCallbackResult();
		$result->setTransactionStatus(Status::ERROR);

		$paymentId = $request->getQuery('paymentId');
		$payerId   = $request->getQuery('PayerID');

		if (empty($paymentId) || empty($payerId))
		{
			return $result;
		}

		$requestPayment = Payment::get($paymentId, $this->api);

		$execution = new PaymentExecution();
		$execution->setPayerId($payerId);

		try
		{
			$requestPayment->execute($execution, $this->api);

			$this->asyncQueueAdder->add(
				AsyncQueueAddData::create()
					->setType(PendingCheckProcessor::ID)
					->setPayLoad(
						[
							'transactionId' => $data
								->getTransaction()
								->getId()
								->toString()
						]
					)
			);

			$result->setForeignId($paymentId);
			$result->setTransactionStatus(Status::PENDING);
		}
		catch (Exception $ex)
		{
			Log::error($ex);
		}

		return $result;
	}

	/**
	 *
	 */
	private function createPayPalPayment()
	{
		$transaction = $this->data->getTransaction();

		$payer = new Payer();
		$payer->setPaymentMethod('paypal');

		$totalAmount = $transaction->getTotalPrice()->getGross() / 100; // amount is cents, so divide by 100

		$details = new Details();
		$details
			->setSubtotal($totalAmount);

		$amount = new Amount();
		$amount->setCurrency('USD') // TODO for testing
			->setTotal($totalAmount)
			->setDetails($details);

		$payPalTransaction = new PayPalTransaction();
		$payPalTransaction
			->setAmount($amount)
			->setDescription(
				sprintf(
					Translator::translate('Bestellung %s'),
					$transaction->getReferenceNumber()
				)
			)
			->setInvoiceNumber($transaction->getReferenceNumber());

		$redirectUrls = new RedirectUrls();
		$redirectUrls
			->setReturnUrl(
				$this->getUrl(CallbackType::SUCCESS, $transaction->getId())
			)
			->setCancelUrl(
				$this->getUrl(CallbackType::CANCEL, $transaction->getId())
			);

		$payment = new Payment();
		$payment
			->setIntent("sale")
			->setPayer($payer)
			->setRedirectUrls($redirectUrls)
			->setTransactions([$payPalTransaction]);

		return $payment;
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
				'method'        => Method::PAY_PAL,
				'type'          => $type,
			]
		);
	}
}