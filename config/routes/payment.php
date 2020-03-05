<?php

use Common\Router\HttpRouteCreator;
use Ecommerce\Payment\CallbackType;
use Ecommerce\Rest\Action\Payment\Callback;

$callbackTypes = [
	CallbackType::SUCCESS,
	CallbackType::CANCEL,
	CallbackType::ERROR,
];

return HttpRouteCreator::create()
	->setRoute('/payment')
	->setMayTerminate(false)
	->setChildRoutes(
		[
			'callback' => HttpRouteCreator::create()
				->setRoute('/callback/:transactionId/:type')
				->setConstraints(
					[
						'transactionId' => '.{36}',
						'type'          => '(' . implode('|', $callbackTypes) . ')',
					]
				)
				->setAction(Callback::class)
				->getConfig()
		]
	)
	->getConfig();