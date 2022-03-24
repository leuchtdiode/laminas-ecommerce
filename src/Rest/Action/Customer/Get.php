<?php
namespace Ecommerce\Rest\Action\Customer;

use Common\Hydration\ObjectToArrayHydrator;
use Ecommerce\Rest\Action\Base;
use Ecommerce\Rest\Action\Response;
use Exception;
use Laminas\Stdlib\ResponseInterface;
use Laminas\View\Model\JsonModel;

class Get extends Base
{
	/**
	 * @throws Exception
	 */
	public function executeAction(): JsonModel|ResponseInterface
	{
		$customerId = $this->params()->fromRoute('id');

		if (!$this->customerCheck($customerId))
		{
			return $this->forbidden();
		}

		return Response::is()
			->successful()
			->data(
				ObjectToArrayHydrator::hydrate(
					GetSuccessData::create()
						->setCustomer($this->getCustomer())
				)
			)
			->dispatch();
	}
}