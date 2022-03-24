<?php
namespace Ecommerce\Product\Image;

use Common\Db\FilterChain;
use Common\Db\OrderChain;
use Ecommerce\Common\DtoCreatorProvider;
use Ecommerce\Db\Product\Image\Entity;
use Ecommerce\Db\Product\Image\Repository;

class Provider
{
	private Repository $repository;

	private DtoCreatorProvider $dtoCreatorProvider;

	public function __construct(Repository $repository, DtoCreatorProvider $dtoCreatorProvider)
	{
		$this->repository         = $repository;
		$this->dtoCreatorProvider = $dtoCreatorProvider;
	}

	/**
	 * @return Image[]
	 */
	public function filter(FilterChain $filterChain, ?OrderChain $orderChain = null): array
	{
		return $this->createDtos(
			$this->repository->filter($filterChain, $orderChain)
		);
	}

	/**
	 * @param Entity[] $entities
	 * @return Image[]
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

	private function createDto(Entity $entity): Image
	{
		return $this->dtoCreatorProvider
			->getProductImageCreator()
			->byEntity($entity);
	}
}