<?php
namespace Ecommerce\Transaction;

use Common\Db\OrderChain;
use Exception;
use Common\Db\FilterChain;
use Ecommerce\Common\DtoCreatorProvider;
use Ecommerce\Db\Transaction\Entity;
use Ecommerce\Db\Transaction\Repository;

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
	public function byId(string $id): ?Transaction
	{
		return ($entity = $this->repository->find($id))
			? $this->createDto($entity)
			: null;
	}

	/**
	 * @return Transaction[]
	 * @throws Exception
	 */
	public function filter(FilterChain $filterChain, ?OrderChain $orderChain = null): array
	{
		return $this->createDtos(
			$this->repository->filter($filterChain, $orderChain)
		);
	}

	/**
	 * @param Entity[] $entities
	 * @return Transaction[]
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
	private function createDto(Entity $entity): Transaction
	{
		return $this->dtoCreatorProvider
			->getTransactionCreator()
			->byEntity($entity);
	}
}