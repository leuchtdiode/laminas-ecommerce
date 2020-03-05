<?php
namespace Ecommerce;

use Common\Router\HttpRouteCreator;
use Ecommerce\Rest\Action\Customer\Password\Request;

return HttpRouteCreator::create()
	->setRoute('/password')
	->setMayTerminate(false)
	->setChildRoutes(
		[
			'request' => HttpRouteCreator::create()
				->setAction(Request::class)
				->setMethods([ 'POST' ])
				->getConfig(),
		]
	)
	->getConfig();