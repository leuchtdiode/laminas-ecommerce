<?php
namespace Ecommerce\Address;

use Common\Db\FilterChain;
use Ecommerce\Common\DtoCreatorProvider;
use Ecommerce\Db\Address\Entity;
use Ecommerce\Db\Address\Repository;
use Exception;

class Provider
{
	private DtoCreatorProvider $dtoCreatorProvider;

	private Repository $repository;

	public function __construct(DtoCreatorProvider $dtoCreatorProvider, Repository $repository)
	{
		$this->dtoCreatorProvider = $dtoCreatorProvider;
		$this->repository         = $repository;
	}

	/**
	 * @throws Exception
	 */
	public function byId(string $id): ?Address
	{
		return ($entity = $this->repository->find($id))
			? $this->createDto($entity)
			: null;
	}

	/**
	 * @return Address[]
	 * @throws Exception
	 */
	public function filter(FilterChain $filterChain): array
	{
		return $this->createDtos(
			$this->repository->filter($filterChain)
		);
	}

	/**
	 * @param Entity[] $entities
	 * @return Address[]
	 * @throws Exception
	 */
	private function createDtos(array $entities): array
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
	 * @throws Exception
	 */
	private function createDto(Entity $entity): Address
	{
		return $this->dtoCreatorProvider
			->getAddressCreator()
			->byEntity($entity);
	}
}