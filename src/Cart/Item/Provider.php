<?php
namespace Ecommerce\Cart\Item;

use Ecommerce\Common\DtoCreatorProvider;
use Ecommerce\Db\Cart\Item\Entity;
use Ecommerce\Db\Cart\Item\Repository;

class Provider
{
	private DtoCreatorProvider $dtoCreatorProvider;

	private Repository $repository;

	public function __construct(DtoCreatorProvider $dtoCreatorProvider, Repository $repository)
	{
		$this->dtoCreatorProvider = $dtoCreatorProvider;
		$this->repository         = $repository;
	}

	public function byId($id): ?Item
	{
		return ($entity = $this->repository->find($id))
			? $this->createDto($entity)
			: null;
	}

	private function createDto(Entity $entity): Item
	{
		return $this->dtoCreatorProvider
			->getCartItemCreator()
			->byEntity($entity);
	}
}