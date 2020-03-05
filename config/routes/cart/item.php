<?php
namespace Ecommerce;

use Common\Router\HttpRouteCreator;
use Ecommerce\Rest\Action\Cart\Item\Add;
use Ecommerce\Rest\Action\Cart\Item\Remove;

return HttpRouteCreator::create()
	->setRoute('/item')
	->setMayTerminate(false)
	->setChildRoutes(
		[
			'add'         => HttpRouteCreator::create()
				->setMethods([ 'POST' ])
				->setAction(Add::class)
				->getConfig(),
			'single-item' => HttpRouteCreator::create()
				->setRoute('/:cartItemId')
				->setConstraints(
					[
						'cartItemId' => '.{36}'
					]
				)
				->setMayTerminate(false)
				->setChildRoutes(
					[
						'remove' => HttpRouteCreator::create()
							->setMethods([ 'DELETE' ])
							->setAction(Remove::class)
							->getConfig(),
					]
				)
				->getConfig(),
		]
	)
	->getConfig();