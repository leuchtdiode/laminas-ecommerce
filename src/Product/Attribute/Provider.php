<?php
namespace Ecommerce\Product\Attribute;

use Common\Db\FilterChain;
use Common\Db\OrderChain;
use Ecommerce\Common\DtoCreatorProvider;
use Ecommerce\Db\Product\Attribute\Entity;
use Ecommerce\Db\Product\Attribute\Repository;

class Provider
{
	private DtoCreatorProvider $dtoCreatorProvider;

	private Repository $repository;

	public function __construct(DtoCreatorProvider $dtoCreatorProvider, Repository $repository)
	{
		$this->dtoCreatorProvider = $dtoCreatorProvider;
		$this->repository         = $repository;
	}

	public function byId(string $id): ?Attribute
	{
		return ($entity = $this->repository->find($id))
			? $this->createDto($entity)
			: null;
	}

	public function byProcessableId(string $number): ?Attribute
	{
		return ($entity = $this->repository->findOneBy([ 'processableId' => $number ]))
			? $this->createDto($entity)
			: null;
	}

	/**
	 * @return Attribute[]
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
	 * @return Attribute[]
	 */
	private function createDtos(array $entities): array
	{
		return array_map([ $this, 'createDto' ], $entities);
	}

	private function createDto(Entity $entity): Attribute
	{
		return $this->dtoCreatorProvider
			->getProductAttributeCreator()
			->byEntity($entity);
	}
}