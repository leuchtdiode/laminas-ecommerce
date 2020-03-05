<?php
namespace Ecommerce\Address;

use Common\Db\FilterChain;
use Ecommerce\Common\DtoCreatorProvider;
use Ecommerce\Db\Address\Entity;
use Ecommerce\Db\Address\Filter\Customer as CustomerFilter;
use Ecommerce\Db\Address\Filter\Id as IdFilter;
use Ecommerce\Db\Address\Saver;
use Exception;
use Log\Log;

class AddModifyHandler
{
	/**
	 * @var Saver
	 */
	private $entitySaver;

	/**
	 * @var DtoCreatorProvider
	 */
	private $dtoCreatorProvider;

	/**
	 * @var Provider
	 */
	private $addressProvider;

	/**
	 * @param Saver $entitySaver
	 * @param DtoCreatorProvider $dtoCreatorProvider
	 * @param Provider $addressProvider
	 */
	public function __construct(Saver $entitySaver, DtoCreatorProvider $dtoCreatorProvider, Provider $addressProvider)
	{
		$this->entitySaver        = $entitySaver;
		$this->dtoCreatorProvider = $dtoCreatorProvider;
		$this->addressProvider    = $addressProvider;
	}

	/**
	 * @param AddModifyData $data
	 * @return AddModifyResult
	 */
	public function addOrModify(AddModifyData $data)
	{
		$result = new AddModifyResult();
		$result->setSuccess(false);

		$customer = $data->getCustomer();

		try
		{
			$entity = $data->getAddress()
				? $data->getAddress()->getEntity()
				: new Entity();
			$entity->setCustomer($customer->getEntity());
			$entity->setZip($data->getZip());
			$entity->setCity($data->getCity());
			$entity->setCountry($data->getCountry());
			$entity->setStreet($data->getStreet());
			$entity->setExtra($data->getExtra());
			$entity->setDefaultBilling($data->isDefaultBilling());
			$entity->setDefaultShipping($data->isDefaultShipping());

			$this->entitySaver->save($entity);

			$this->ensureOnlyOneDefaultAddressPerType($customer->getId(), $entity);

			$result->setSuccess(true);
			$result->setAddress(
				$this->dtoCreatorProvider
					->getAddressCreator()
					->byEntity($entity)
			);
		}
		catch (Exception $ex)
		{
			Log::error($ex);
		}

		return $result;
	}

	/**
	 * @param Entity $addressEntity
	 * @throws Exception
	 */
	private function ensureOnlyOneDefaultAddressPerType(string $customerId, Entity $addressEntity)
	{
		$otherCustomerAddresses = $this->addressProvider->filter(
			FilterChain::create()
				->addFilter(CustomerFilter::is($customerId))
				->addFilter(IdFilter::isNot($addressEntity->getId()))
		);

		foreach ($otherCustomerAddresses as $customerAddress)
		{
			$saveAddress           = false;
			$customerAddressEntity = $customerAddress->getEntity();

			if ($addressEntity->isDefaultBilling() && $customerAddress->isDefaultBilling())
			{
				$customerAddressEntity->setDefaultBilling(false);

				$saveAddress = true;
			}

			if ($addressEntity->isDefaultShipping() && $customerAddress->isDefaultShipping())
			{
				$customerAddressEntity->setDefaultShipping(false);

				$saveAddress = true;
			}

			if ($saveAddress)
			{
				$this->entitySaver->save($customerAddressEntity);
			}
		}
	}
}