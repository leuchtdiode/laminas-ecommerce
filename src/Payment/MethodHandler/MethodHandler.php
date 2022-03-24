<?php
namespace Ecommerce\Payment\MethodHandler;

interface MethodHandler
{
	public function init(InitData $data): InitResult;

	public function handleCallback(HandleCallbackData $data): HandleCallbackResult;
}