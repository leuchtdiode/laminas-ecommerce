<?php
namespace Ecommerce\Payment\MethodHandler\AmazonPay;

use Ecommerce\Payment\MethodHandler\HandleCallbackData;
use Ecommerce\Payment\MethodHandler\HandleCallbackResult;
use Ecommerce\Payment\MethodHandler\InitData;
use Ecommerce\Payment\MethodHandler\InitResult;
use Ecommerce\Payment\MethodHandler\MethodHandler as MethodHandlerInterface;
use Exception;

class MethodHandler implements MethodHandlerInterface
{
	/**
	 * @throws Exception
	 */
	public function init(InitData $data): InitResult
	{
		throw new Exception('Not yet implemented');
	}

	/**
	 * @throws Exception
	 */
	public function handleCallback(HandleCallbackData $data): HandleCallbackResult
	{
		throw new Exception('Not yet implemented');
	}
}