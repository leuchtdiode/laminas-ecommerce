<?php
namespace Ecommerce;

use Common\Router\HttpRouteCreator;
use Ecommerce\Rest\Action\Product\Image\GetList;

return HttpRouteCreator::create()
	->setRoute('/image')
	->setMayTerminate(false)
	->setChildRoutes(
		[
			'get-list' => HttpRouteCreator::create()
				->setMethods(['GET'])
				->setAction(GetList::class)
				->getConfig(),
		]
	)
	->getConfig();