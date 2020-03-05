<?php
namespace Ecommerce\Product\Image;

use Common\Db\FilterChain;
use Common\Db\OrderChain;
use Ecommerce\Common\DtoCreatorProvider;
use Ecommerce\Db\Product\Image\Entity;
use Ecommerce\Db\Product\Image\Repository;

class Provider
{
	/**
	 * @var Repository
	 */
	private $repository;

	/**
	 * @var DtoCreatorProvider
	 */
	private $dtoCreatorProvider;

	/**
	 * @param Repository $repository
	 * @param DtoCreatorProvider $dtoCreatorProvider
	 */
	public function __construct(Repository $repository, DtoCreatorProvider $dtoCreatorProvider)
	{
		$this->repository         = $repository;
		$this->dtoCreatorProvider = $dtoCreatorProvider;
	}

	/**
	 * @param FilterChain $filterChain
	 * @param OrderChain|null $orderChain
	 * @return Image[]
	 */
	public function filter(FilterChain $filterChain, ?OrderChain $orderChain = null)
	{
		return $this->createDtos(
			$this->repository->filter($filterChain, $orderChain)
		);
	}

	/**
	 * @param Entity[] $entities
	 * @return Image[]
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
	 * @return Image
	 */
	private function createDto(Entity $entity)
	{
		return $this->dtoCreatorProvider
			->getProductImageCreator()
			->byEntity($entity);
	}
}