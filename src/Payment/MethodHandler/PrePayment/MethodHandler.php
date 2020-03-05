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
use Ecommerce\Transaction\Provider;
use Ecommerce\Transaction\SaveData;
use Ecommerce\Transaction\Saver;
use Ecommerce\Transaction\Status;
use Exception;

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
	 * @var Handler
	 */
	private $postPaymentHandler;

	/**
	 * @var Provider
	 */
	private $transactionProvider;

	/**
	 * @param array $config
	 * @param Saver $saver
	 * @param Handler $postPaymentHandler
	 * @param Provider $transactionProvider
	 */
	public function __construct(array $config, Saver $saver, Handler $postPaymentHandler, Provider $transactionProvider)
	{
		$this->config              = $config;
		$this->saver               = $saver;
		$this->postPaymentHandler  = $postPaymentHandler;
		$this->transactionProvider = $transactionProvider;
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

		$this->postPaymentHandler->successful(
			SuccessfulData::create()
				->setTransaction($transaction)
		);

		$initResult->setSuccess(true);
		$initResult->setRedirectUrl(
			$this->config['ecommerce']['payment']['returnUrls'][CallbackType::PRE_PAYMENT]
		);

		return $initResult;
	}

	/**
	 * @param HandleCallbackData $data
	 * @return HandleCallbackResult
	 */
	public function handleCallback(HandleCallbackData $data): HandleCallbackResult
	{
		// no callback for pre payment
		return new HandleCallbackResult();
	}
}