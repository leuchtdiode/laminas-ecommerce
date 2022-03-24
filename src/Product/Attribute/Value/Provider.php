<?php
namespace Ecommerce\Product\Attribute\Value;

use Common\Db\FilterChain;
use Common\Db\OrderChain;
use Ecommerce\Common\DtoCreatorProvider;
use Ecommerce\Db\Product\Attribute\Value\Entity;
use Ecommerce\Db\Product\Attribute\Value\Repository;

class Provider
{
	private DtoCreatorProvider $dtoCreatorProvider;

	private Repository $repository;

	public function __construct(DtoCreatorProvider $dtoCreatorProvider, Repository $repository)
	{
		$this->dtoCreatorProvider = $dtoCreatorProvider;
		$this->repository         = $repository;
	}

	public function byId(string $id): ?Value
	{
		return ($entity = $this->repository->find($id))
			? $this->createDto($entity)
			: null;
	}

	/**
	 * @return Value[]
	 */
	public function filter(
		FilterChain $filterChain,
		?OrderChain $orderChain = null,
		int $offset = 0,
		int $limit = PHP_INT_MAX
	): array
	{
		return $this->createDtos(
			$this->repository->filter($filterChain, $orderChain, $offset, $limit)
		);
	}

	/**
	 * @param Entity[] $entities
	 * @return Value[]
	 */
	private function createDtos(array $entities): array
	{
		return array_map([ $this, 'createDto' ], $entities);
	}

	private function createDto(Entity $entity): Value
	{
		return $this->dtoCreatorProvider
			->getProductAttributeValueCreator()
			->byEntity($entity);
	}
}