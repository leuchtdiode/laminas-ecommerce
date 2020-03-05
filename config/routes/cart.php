<?php
namespace Ecommerce;

use Common\Router\HttpRouteCreator;
use Ecommerce\Rest\Action\Cart\Get;
use Ecommerce\Rest\Action\Cart\Checkout;

return HttpRouteCreator::create()
	->setRoute('/cart')
	->setMayTerminate(false)
	->setChildRoutes(
		[
			'item'        => include 'cart/item.php',
			'single-item' => HttpRouteCreator::create()
				->setRoute('/:cartId')
				->setConstraints(
					[
						'cartId' => '.{36}',
					]
				)
				->setMayTerminate(false)
				->setChildRoutes(
					[
						'item' => include 'cart/item.php',
						'get' => HttpRouteCreator::create()
							->setMethods(['GET'])
							->setAction(Get::class)
							->getConfig(),
						'checkout' => HttpRouteCreator::create()
							->setRoute('/checkout')
							->setAction(Checkout::class)
							->getConfig(),
					]
				)
				->getConfig(),
		]
	)
	->getConfig();