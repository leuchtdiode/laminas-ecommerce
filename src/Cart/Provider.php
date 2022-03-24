<?php
namespace Ecommerce\Cart;

use Ecommerce\Common\DtoCreatorProvider;
use Ecommerce\Db\Cart\Entity;
use Ecommerce\Db\Cart\Repository;

class Provider
{
	private DtoCreatorProvider $dtoCreatorProvider;

	private Repository $repository;

	private Validator $validator;

	public function __construct(DtoCreatorProvider $dtoCreatorProvider, Repository $repository, Validator $validator)
	{
		$this->dtoCreatorProvider = $dtoCreatorProvider;
		$this->repository         = $repository;
		$this->validator          = $validator;
	}

	public function byId(string $id): ?Cart
	{
		return ($entity = $this->repository->find($id))
			? $this->createDto($entity)
			: null;
	}

	private function createDto(Entity $entity): Cart
	{
		$cart = $this->dtoCreatorProvider
			->getCartCreator()
			->byEntity($entity);

		$this->validator->validate($cart);

		return $cart;
	}
}