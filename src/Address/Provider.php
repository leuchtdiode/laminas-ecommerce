<?php
namespace Ecommerce\Address;

use Common\Db\FilterChain;
use Ecommerce\Common\DtoCreatorProvider;
use Ecommerce\Db\Address\Entity;
use Ecommerce\Db\Address\Repository;
use Exception;

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
	 * @param string $id
	 * @return Address|null
	 * @throws Exception
	 */
	public function byId($id)
	{
		return ($entity = $this->repository->find($id))
			? $this->createDto($entity)
			: null;
	}

	/**
	 * @param FilterChain $filterChain
	 * @return Address[]
	 */
	public function filter(FilterChain $filterChain)
	{
		return $this->createDtos(
			$this->repository->filter($filterChain)
		);
	}

	/**
	 * @param Entity[] $entities
	 * @return Address[]
	 */
	private function createDtos(array $entities)
	{
		return array_map(
			function (Entity $entity)
			{
				return $this->createDto($entity);
			},
			$entities
		);
	}

	/**
	 * @param Entity $entity
	 * @return Address
	 * @throws Exception
	 */
	private function createDto(Entity $entity)
	{
		return $this->dtoCreatorProvider
			->getAddressCreator()
			->byEntity($entity);
	}
}