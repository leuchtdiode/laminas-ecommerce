<?php
namespace Ecommerce\Product;

use Common\Db\FilterChain;
use Common\Db\OrderChain;
use Ecommerce\Common\DtoCreatorProvider;
use Ecommerce\Db\Product\Entity;
use Ecommerce\Db\Product\Repository;

class Provider
{
	private DtoCreatorProvider $dtoCreatorProvider;

	private Repository $repository;

	public function __construct(DtoCreatorProvider $dtoCreatorProvider, Repository $repository)
	{
		$this->dtoCreatorProvider = $dtoCreatorProvider;
		$this->repository         = $repository;
	}

	public function byId(string $id): ?Product
	{
		return ($entity = $this->repository->find($id))
			? $this->createDto($entity)
			: null;
	}

	public function byNumber(string $number): ?Product
	{
		return ($entity = $this->repository->findOneBy([ 'number' => $number ]))
			? $this->createDto($entity)
			: null;
	}

	/**
	 * @return Product[]
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

	private function createDto(Entity $entity): Product
	{
		return $this->dtoCreatorProvider
			->getProductCreator()
			->byEntity($entity);
	}

	/**
	 * @param Entity[] $entities
	 * @return Product[]
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
}