<?php
namespace Ecommerce\Customer;

use Ecommerce\Common\DtoCreatorProvider;
use Ecommerce\Db\Customer\Entity;
use Ecommerce\Db\Customer\Repository;

class Provider
{
	private DtoCreatorProvider $dtoCreatorProvider;

	private Repository $repository;

	public function __construct(DtoCreatorProvider $dtoCreatorProvider, Repository $repository)
	{
		$this->dtoCreatorProvider = $dtoCreatorProvider;
		$this->repository         = $repository;
	}

	public function byId(string $id): ?Customer
	{
		$entity = $this->repository->find($id);

		return $entity
			? $this->createDto($entity)
			: null;
	}

	public function byEmail(string $email): ?Customer
	{
		$entity = $this->repository->findOneBy(['email' => $email]);

		return $entity
			? $this->createDto($entity)
			: null;
	}

	private function createDto(Entity $entity): Customer
	{
		return $this->dtoCreatorProvider
			->getCustomerCreator()
			->byEntity($entity);
	}
}