<?php
namespace Ecommerce\Payment\MethodHandler\PrePayment;

use Ecommerce\Payment\CallbackType;
use Ecommerce\Payment\MethodHandler\HandleCallbackData;
use Ecommerce\Payment\MethodHandler\HandleCallbackResult;
use Ecommerce\Payment\MethodHandler\InitData;
use Ecommerce\Payment\MethodHandler\InitResult;
use Ecommerce\Payment\MethodHandler\MethodHandler as MethodHandlerInterface;
use Ecommerce\Payment\PostPayment\Handler;
use Ecommerce\Payment\PostPayment\SuccessfulData;
use Ecommerce\Payment\ReturnUrl\GetData;
use Ecommerce\Payment\ReturnUrl\Provider as ReturnUrlProvider;
use Ecommerce\Transaction\Provider;
use Ecommerce\Transaction\SaveData;
use Ecommerce\Transaction\Saver;
use Ecommerce\Transaction\Status;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class MethodHandler implements MethodHandlerInterface
{
	private Saver $saver;

	private Handler $postPaymentHandler;

	private Provider $transactionProvider;

	private ReturnUrlProvider $returnUrlProvider;

	public function __construct(
		Saver $saver,
		Handler $postPaymentHandler,
		Provider $transactionProvider,
		ReturnUrlProvider $returnUrlProvider
	)
	{
		$this->saver               = $saver;
		$this->postPaymentHandler  = $postPaymentHandler;
		$this->transactionProvider = $transactionProvider;
		$this->returnUrlProvider   = $returnUrlProvider;
	}

	/**
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 */
	public function init(InitData $data): InitResult
	{
		$initResult = new InitResult();
		$initResult->setSuccess(false);

		$saveResult = $this->saver->save(
			SaveData::create()
				->setTransaction($transaction = $data->getTransaction())
				->setStatus(Status::SUCCESS)
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

		$this->postPaymentHandler->successful(
			SuccessfulData::create()
				->setTransaction($transaction)
		);

		$initResult->setSuccess(true);
		$initResult->setRedirectUrl(
			$this->returnUrlProvider->get(
				GetData::create()
					->setLocale(
						$transaction
							->getCustomer()
							->getLocale()
					)
					->setCallbackType(CallbackType::PRE_PAYMENT)
			)
		);

		return $initResult;
	}

	public function handleCallback(HandleCallbackData $data): HandleCallbackResult
	{
		// no callback for pre-payment
		return new HandleCallbackResult();
	}
}