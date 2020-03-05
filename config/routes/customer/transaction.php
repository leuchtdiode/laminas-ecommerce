<?php
namespace Ecommerce;

use Common\Router\HttpRouteCreator;
use Ecommerce\Rest\Action\Customer\Transaction\GetList;

return HttpRouteCreator::create()
	->setRoute('/transaction')
	->setAction(GetList::class)
	->setMayTerminate(true)
	->setChildRoutes(
		[
			'get-list' => HttpRouteCreator::create()
				->setAction(GetList::class)
				->setMethods(['GET'])
				->getConfig()
		]
	)
	->getConfig();