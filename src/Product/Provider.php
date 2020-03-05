<?php
namespace Ecommerce\Product;

use Common\Db\FilterChain;
use Common\Db\OrderChain;
use Ecommerce\Common\DtoCreatorProvider;
use Ecommerce\Db\Product\Entity;
use Ecommerce\Db\Product\Repository;

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
	 * @return Product|null
	 */
	public function byId($id)
	{
		return ($entity = $this->repository->find($id))
			? $this->createDto($entity)
			: null;
	}

	/**
	 * @param string $number
	 * @return Product|null
	 */
	public function byNumber($number)
	{
		return ($entity = $this->repository->findOneBy(['number' => $number]))
			? $this->createDto($entity)
			: null;
	}

	/**
	 * @param FilterChain $filterChain
	 * @param OrderChain|null $orderChain
	 * @param int $offset
	 * @param int $limit
	 * @return Product[]
	 */
	public function filter(FilterChain $filterChain, ?OrderChain $orderChain = null, $offset = 0, $limit = PHP_INT_MAX)
	{
		return $this->createDtos(
			$this->repository->filter($filterChain, $orderChain, $offset, $limit)
		);
	}

	/**
	 * @param Entity $entity
	 * @return Product
	 */
	private function createDto(Entity $entity)
	{
		return $this->dtoCreatorProvider
			->getProductCreator()
			->byEntity($entity);
	}

	/**
	 * @param array $entities
	 * @return Product[]
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
}