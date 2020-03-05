<?php
namespace Ecommerce;

use Common\Router\HttpRouteCreator;
use Ecommerce\Rest\Action\Transaction\Invoice;

return HttpRouteCreator::create()
	->setRoute('/invoice/:referenceNumber:.pdf')
	->setConstraints(
		[
			'referenceNumber' => '[A-Z]+'
		]
	)
	->setAction(Invoice::class)
	->getConfig();