<?php
namespace Ecommerce\Rest\Action\Customer\Address;

use Common\Hydration\ObjectToArrayHydrator;
use Ecommerce\Address\AddModifyHandler;
use Ecommerce\Address\AddModifyData as AddressAddModifyData;
use Ecommerce\Address\Provider as AddressProvider;
use Ecommerce\Rest\Action\Base;
use Ecommerce\Rest\Action\Response;
use Exception;

class AddOrModify extends Base
{
	/**
	 * @var AddOrModifyData
	 */
	private $data;

	/**
	 * @var AddModifyHandler
	 */
	private $addModifyHandler;

	/**
	 * @var AddressProvider
	 */
	private $addressProvider;

	/**
	 * @param AddOrModifyData $data
	 * @param AddModifyHandler $addModifyHandler
	 * @param AddressProvider $addressProvider
	 */
	public function __construct(
		AddOrModifyData $data,
		AddModifyHandler $addModifyHandler,
		AddressProvider $addressProvider
	)
	{
		$this->data = $data;
		$this->addModifyHandler = $addModifyHandler;
		$this->addressProvider = $addressProvider;
	}

	/**
	 * @return string
	 * @throws Exception
	 */
	public function executeAction()
	{
		$customerId = $this
			->params()
			->fromRoute('id');

		if (!$this->customerCheck($customerId))
		{
			return $this->forbidden();
		}

		$addressId = $this
			->params()
			->fromRoute('addressId');

		$address = null;

		if ($addressId)
		{
			$address = $this->addressProvider->byId($addressId);
		}

		$values = $this->data
			->setRequest($this->getRequest())
			->getValues();

		if ($values->hasErrors())
		{
			return Response::is()
				->unsuccessful()
				->errors($values->getErrors())
				->dispatch();
		}

		$result = $this->addModifyHandler->addOrModify(
			AddressAddModifyData::create()
				->setAddress($address)
				->setCustomer($this->getCustomer())
				->setCountry(
					$values
						->get(AddOrModifyData::COUNTRY)
						->getValue()
				)
				->setZip(
					$values
						->get(AddOrModifyData::ZIP)
						->getValue()
				)
				->setCity(
					$values
						->get(AddOrModifyData::CITY)
						->getValue()
				)
				->setStreet(
					$values
						->get(AddOrModifyData::STREET)
						->getValue()
				)
				->setExtra(
					$values
						->get(AddOrModifyData::EXTRA)
						->getValue()
				)
				->setDefaultBilling(
					$values
						->get(AddOrModifyData::DEFAULT_BILLING)
						->getValue() ?? false
				)
				->setDefaultShipping(
					$values
						->get(AddOrModifyData::DEFAULT_SHIPPING)
						->getValue() ?? false
				)
		);

		if (!$result->isSuccess())
		{
			return Response::is()
				->unsuccessful()
				->errors($result->getErrors())
				->dispatch();
		}

		return Response::is()
			->successful()
			->data(
				ObjectToArrayHydrator::hydrate(
					AddOrModifySuccessData::create()
						->setAddress($result->getAddress())
				)
			)
			->dispatch();
	}
}