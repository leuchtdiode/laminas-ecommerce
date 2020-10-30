<?php
namespace Ecommerce;

use Common\Router\HttpRouteCreator;
use Ecommerce\Rest\Action\Invoice\Bulk;

return HttpRouteCreator::create()
	->setRoute('/invoice')
	->setMayTerminate(false)
	->setChildRoutes(
		[
			'bulk' => HttpRouteCreator::create()
				->setRoute('/bulk')
				->setAction(Bulk::class)
				->getConfig(),
		]
	)
	->getConfig();