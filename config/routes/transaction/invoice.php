<?php
namespace Ecommerce;

use Common\Router\HttpRouteCreator;
use Ecommerce\Rest\Action\Transaction\Invoice;

return HttpRouteCreator::create()
	->setRoute('/invoice')
	->setMayTerminate(false)
	->setChildRoutes(
		[
			'pdf' => HttpRouteCreator::create()
				->setRoute('/:referenceNumber:.pdf')
				->setConstraints(
					[
						'referenceNumber' => '[A-Z]+',
					]
				)
				->setAction(Invoice::class)
				->getConfig(),
		]
	)
	->getConfig();