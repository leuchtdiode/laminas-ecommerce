<?php
namespace Ecommerce\Cart\Item;

use Common\Dto\Dto;
use Common\Error;
use Common\Hydration\ArrayHydratable;
use Common\Hydration\ObjectToArrayHydratorProperty;
use Ecommerce\Db\Cart\Item\Entity;
use Ecommerce\Product\Product;
use Ramsey\Uuid\UuidInterface;

class Item implements Dto, ArrayHydratable
{
	private Entity $entity;

	private Product $product;

	/**
	 * @var Error[]
	 */
	private array $validationErrors = [];

	public function __construct(Entity $entity, Product $product)
	{
		$this->entity  = $entity;
		$this->product = $product;
	}

	public function addValidationError(Error $error): void
	{
		$this->validationErrors[] = $error;
	}

	#[ObjectToArrayHydratorProperty]
	public function isValid(): bool
	{
		return empty($this->validationErrors);
	}

	#[ObjectToArrayHydratorProperty]
	public function getProduct(): Product
	{
		return $this->product;
	}

	#[ObjectToArrayHydratorProperty]
	public function getId(): UuidInterface
	{
		return $this->entity->getId();
	}

	/**
	 * @return Error[]
	 */
	#[ObjectToArrayHydratorProperty]
	public function getValidationErrors(): array
	{
		return $this->validationErrors;
	}

	#[ObjectToArrayHydratorProperty]
	public function getQuantity(): int
	{
		return $this->entity->getQuantity();
	}

	public function getEntity(): Entity
	{
		return $this->entity;
	}
}