<?php
namespace Ecommerce\Customer;

use Ecommerce\Common\DtoCreatorProvider;
use Ecommerce\Db\Customer\Entity;
use Ecommerce\Db\Customer\Repository;

class Provider
{
	/**
	 * @var DtoCreatorProvider
	 */
	private $dtoCreatorProvider;

	/**
	 * @var Repository
	 */
	private $repository;

	/**
	 * @param DtoCreatorProvider $dtoCreatorProvider
	 * @param Repository $repository
	 */
	public function __construct(DtoCreatorProvider $dtoCreatorProvider, Repository $repository)
	{
		$this->dtoCreatorProvider = $dtoCreatorProvider;
		$this->repository         = $repository;
	}

	/**
	 * @param $id
	 * @return Customer|null
	 */
	public function byId($id)
	{
		$entity = $this->repository->find($id);

		return $entity
			? $this->createDto($entity)
			: null;
	}

	/**
	 * @param $email
	 * @return Customer|null
	 */
	public function byEmail($email)
	{
		$entity = $this->repository->findOneBy(['email' => $email]);

		return $entity
			? $this->createDto($entity)
			: null;
	}

	/**
	 * @param Entity $entity
	 * @return Customer|null
	 */
	private function createDto(Entity $entity)
	{
		return $this->dtoCreatorProvider
			->getCustomerCreator()
			->byEntity($entity);
	}
}