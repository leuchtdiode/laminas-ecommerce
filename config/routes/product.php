<?php
namespace Ecommerce;

use Common\Router\HttpRouteCreator;
use Ecommerce\Rest\Action\Product\Get;
use Ecommerce\Rest\Action\Product\GetList;

return HttpRouteCreator::create()
	->setRoute('/product')
	->setMayTerminate(false)
	->setChildRoutes(
		[
			'get-list'    => HttpRouteCreator::create()
				->setMethods(['GET'])
				->setAction(GetList::class)
				->getConfig(),
			'single-item' => HttpRouteCreator::create()
				->setRoute('/:productId')
				->setConstraints(
					[
						'productId' => '.{36}'
					]
				)
				->setMayTerminate(false)
				->setChildRoutes(
					[
						'get'   => HttpRouteCreator::create()
							->setMethods(['GET'])
							->setAction(Get::class)
							->getConfig(),
						'image' => include 'product/image.php',
					]
				)
				->getConfig(),
		]
	)
	->getConfig();