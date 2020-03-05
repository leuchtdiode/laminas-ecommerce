<?php
namespace Ecommerce;

use Common\Router\HttpRouteCreator;
use Ecommerce\Rest\Action\Customer\Address\AddOrModify;
use Ecommerce\Rest\Action\Customer\Address\GetList;

return HttpRouteCreator::create()
	->setRoute('/address')
	->setMayTerminate(false)
	->setChildRoutes(
		[
			'get-list'    => HttpRouteCreator::create()
				->setAction(GetList::class)
				->setMethods([ 'GET' ])
				->getConfig(),
			'add'         => HttpRouteCreator::create()
				->setAction(AddOrModify::class)
				->setMethods([ 'POST' ])
				->getConfig(),
			'single-item' => HttpRouteCreator::create()
				->setRoute('/:addressId')
				->setConstraints(
					[
						'addressId' => '.{36}'
					]
				)
				->setMayTerminate(false)
				->setChildRoutes(
					[
						'modify' => HttpRouteCreator::create()
							->setAction(AddOrModify::class)
							->setMethods([ 'PUT' ])
							->getConfig(),
					]
				)
				->getConfig(),
		]
	)
	->getConfig();