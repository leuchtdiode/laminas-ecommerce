<?php
namespace Ecommerce\Customer;

use Ecommerce\Common\EntityDtoCreator;
use Ecommerce\Db\Customer\Entity;

class Creator implements EntityDtoCreator
{
	/**
	 * @var StatusProvider
	 */
	private $statusProvider;

	/**
	 * @var SalutationProvider
	 */
	private $salutationProvider;

	/**
	 * @param StatusProvider $statusProvider
	 * @param SalutationProvider $salutationProvider
	 */
	public function __construct(StatusProvider $statusProvider, SalutationProvider $salutationProvider)
	{
		$this->statusProvider     = $statusProvider;
		$this->salutationProvider = $salutationProvider;
	}

	/**
	 * @param Entity $entity
	 * @return Customer
	 */
	public function byEntity($entity)
	{
		return new Customer(
			$entity,
			$this->statusProvider->byId($entity->getStatus()),
			$this->salutationProvider->byId($entity->getSalutation())
		);
	}
}