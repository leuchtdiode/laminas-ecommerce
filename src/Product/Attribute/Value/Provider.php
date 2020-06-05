<?php
namespace Ecommerce\Product\Attribute\Value;

use Common\Db\FilterChain;
use Common\Db\OrderChain;
use Ecommerce\Common\DtoCreatorProvider;
use Ecommerce\Db\Product\Attribute\Value\Entity;
use Ecommerce\Db\Product\Attribute\Value\Repository;

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
	 * @return Value|null
	 */
	public function byId($id)
	{
		return ($entity = $this->repository->find($id))
			? $this->createDto($entity)
			: null;
	}

	/**
	 * @param FilterChain $filterChain
	 * @param OrderChain|null $orderChain
	 * @param int $offset
	 * @param int $limit
	 * @return Value[]
	 */
	public function filter(FilterChain $filterChain, ?OrderChain $orderChain = null, $offset = 0, $limit = PHP_INT_MAX)
	{
		return $this->createDtos(
			$this->repository->filter($filterChain, $orderChain, $offset, $limit)
		);
	}

	/**
	 * @param array $entities
	 * @return Value[]
	 */
	private function createDtos(array $entities)
	{
		return array_map([ $this, 'createDto' ], $entities);
	}

	/**
	 * @param Entity $entity
	 * @return Value
	 */
	private function createDto(Entity $entity)
	{
		return $this->dtoCreatorProvider
			->getProductAttributeValueCreator()
			->byEntity($entity);
	}
}