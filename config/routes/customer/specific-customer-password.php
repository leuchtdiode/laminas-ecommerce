<?php
namespace Ecommerce;

use Common\Router\HttpRouteCreator;
use Ecommerce\Rest\Action\Customer\Password\Change;
use Ecommerce\Rest\Action\Customer\Password\Reset;

return HttpRouteCreator::create()
	->setRoute('/password')
	->setMayTerminate(false)
	->setChildRoutes(
		[
			'change' => HttpRouteCreator::create()
				->setAction(Change::class)
				->setMethods([ 'PUT' ])
				->getConfig(),
			'reset' => HttpRouteCreator::create()
				->setAction(Reset::class)
				->setMethods([ 'POST' ])
				->getConfig(),
		]
	)
	->getConfig();