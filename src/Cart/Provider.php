<?php
namespace Ecommerce\Cart;

use Ecommerce\Common\DtoCreatorProvider;
use Ecommerce\Db\Cart\Entity;
use Ecommerce\Db\Cart\Repository;

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
	 * @var Validator
	 */
	private $validator;

	/**
	 * @param DtoCreatorProvider $dtoCreatorProvider
	 * @param Repository $repository
	 * @param Validator $validator
	 */
	public function __construct(DtoCreatorProvider $dtoCreatorProvider, Repository $repository, Validator $validator)
	{
		$this->dtoCreatorProvider = $dtoCreatorProvider;
		$this->repository         = $repository;
		$this->validator          = $validator;
	}

	/**
	 * @param string $id
	 * @return Cart|null
	 */
	public function byId($id)
	{
		return ($entity = $this->repository->find($id))
			? $this->createDto($entity)
			: null;
	}

	/**
	 * @param Entity $entity
	 * @return Cart
	 */
	private function createDto(Entity $entity)
	{
		$cart = $this->dtoCreatorProvider
			->getCartCreator()
			->byEntity($entity);

		$this->validator->validate($cart);

		return $cart;
	}
}