<?php
namespace Ecommerce\Customer;

use Ecommerce\Common\DtoCreatorProvider;
use Ecommerce\Db\Customer\Saver;
use Exception;
use Log\Log;

class Modifier
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
	 * @param Saver $entitySaver
	 * @param DtoCreatorProvider $dtoCreatorProvider
	 */
	public function __construct(Saver $entitySaver, DtoCreatorProvider $dtoCreatorProvider)
	{
		$this->entitySaver        = $entitySaver;
		$this->dtoCreatorProvider = $dtoCreatorProvider;
	}

	/**
	 * @param Customer $customer
	 * @param ModifyData $data
	 * @return ModifyResult
	 */
	public function modify(Customer $customer, ModifyData $data)
	{
		$result = new ModifyResult();
		$result->setSuccess(false);

		try
		{
			$entity = $customer->getEntity();
			$entity->setSalutation($data->getSalutation());
			$entity->setTitle($data->getTitle());
			$entity->setFirstName($data->getFirstName());
			$entity->setLastName($data->getLastName());
			$entity->setCompany($data->getCompany());
			$entity->setTaxNumber($data->getTaxNumber());

			$this->entitySaver->save($entity);

			$result->setSuccess(true);
			$result->setCustomer(
				$this->dtoCreatorProvider
					->getCustomerCreator()
					->byEntity($entity)
			);
		}
		catch (Exception $ex)
		{
			Log::error($ex);
		}

		return $result;
	}
}