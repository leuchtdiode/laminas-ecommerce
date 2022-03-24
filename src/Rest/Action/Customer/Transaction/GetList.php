<?php
namespace Ecommerce\Rest\Action\Customer\Transaction;

use Common\Db\FilterChain;
use Common\Db\OrderChain;
use Common\Hydration\ObjectToArrayHydrator;
use Common\RequestData\Values;
use Ecommerce\Db\Transaction\Filter\Customer;
use Ecommerce\Db\Transaction\Filter\Status;
use Ecommerce\Db\Transaction\Order\CreatedDate;
use Ecommerce\Rest\Action\Base;
use Ecommerce\Rest\Action\Response;
use Ecommerce\Transaction\Provider;
use Exception;
use Laminas\View\Model\JsonModel;

class GetList extends Base
{
	const ORDER_CREATED_DATE = 'createdDate';

	private GetListData $data;

	private Provider $provider;

	private Values $values;

	public function __construct(GetListData $data, Provider $provider)
	{
		$this->data     = $data;
		$this->provider = $provider;
	}

	/**
	 * @throws Exception
	 */
	public function executeAction(): JsonModel
	{
		$this->values = $this->data
			->setRequest($this->getRequest())
			->getValues();

		if ($this->values->hasErrors())
		{
			return Response::is()
				->unsuccessful()
				->errors($this->values->getErrors())
				->dispatch();
		}

		$transactions = $this->provider->filter(
			$this->buildFilter(),
			$this->buildOrder()
		);

		return Response::is()
			->successful()
			->data(

				ObjectToArrayHydrator::hydrate(
					GetListSuccessData::create()
						->setTransactions($transactions)
				)
			)
			->dispatch();
	}

	private function buildFilter(): FilterChain
	{
		$customerId = $this->getCustomer()->getId();

		$filterChain = FilterChain::create()
			->addFilter(
				Customer::is($customerId)
			);

		if (($status = $this->values->get(GetListData::STATUS)->getValue()))
		{
			$filterChain->addFilter(
				Status::in($status)
			);
		}

		return $filterChain;
	}

	private function buildOrder(): OrderChain
	{
		$orderChain = OrderChain::create();

		$orders = $this->values
				->get(GetListData::ORDER)
				->getValue() ?? [];

		foreach ($orders as $order => $direction)
		{
			if ($order === self::ORDER_CREATED_DATE)
			{
				$orderChain->addOrder(
					CreatedDate::withDirection($direction)
				);
			}
		}

		return $orderChain;
	}
}