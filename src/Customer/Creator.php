<?php
namespace Ecommerce\Customer;

use Common\Db\Entity as DbEntity;
use Ecommerce\Common\EntityDtoCreator;
use Ecommerce\Db\Customer\Entity;

class Creator implements EntityDtoCreator
{
	private StatusProvider $statusProvider;

	private SalutationProvider $salutationProvider;

	public function __construct(StatusProvider $statusProvider, SalutationProvider $salutationProvider)
	{
		$this->statusProvider     = $statusProvider;
		$this->salutationProvider = $salutationProvider;
	}

	/**
	 * @param Entity $entity
	 */
	public function byEntity(DbEntity $entity): Customer
	{
		return new Customer(
			$entity,
			$this->statusProvider->byId($entity->getStatus()),
			$this->salutationProvider->byId($entity->getSalutation())
		);
	}
}