<?php
namespace Ecommerce;

use Common\Router\HttpRouteCreator;

return HttpRouteCreator::create()
	->setRoute('/transaction')
	->setMayTerminate(false)
	->setChildRoutes(
		[
			'single-item' => HttpRouteCreator::create()
				->setRoute('/:transactionId')
				->setConstraints(
					[
						'transactionId' => '.{36}'
					]
				)
				->setMayTerminate(false)
				->setChildRoutes(
					[
						'invoice' => include 'transaction/invoice.php',
					]
				)
				->getConfig(),
		]
	)
	->getConfig();