<?php
namespace Ecommerce\Transaction\Item;

use Common\Dto\Dto;
use Common\Hydration\ArrayHydratable;
use Common\Hydration\ObjectToArrayHydratorProperty;
use Ecommerce\Common\Price;
use Ecommerce\Db\Transaction\Item\Entity;
use Ecommerce\Product\Product;
use Ramsey\Uuid\UuidInterface;

class Item implements Dto, ArrayHydratable
{
	private Entity $entity;

	#[ObjectToArrayHydratorProperty]
	private Price $totalPrice;

	#[ObjectToArrayHydratorProperty]
	private Product $product;

	public function __construct(Entity $entity, Price $totalPrice, Product $product)
	{
		$this->entity     = $entity;
		$this->totalPrice = $totalPrice;
		$this->product    = $product;
	}

	public function getProduct(): Product
	{
		return $this->product;
	}

	#[ObjectToArrayHydratorProperty]
	public function getPrice(): Price
	{
		$cents = $this->getTotalPrice()->getNet();

		return Price::fromCents(
			$cents / $this->getAmount(),
			$this->getTotalPrice()->getTaxRate()
		);
	}

	public function getTotalPrice(): Price
	{
		return $this->totalPrice;
	}

	#[ObjectToArrayHydratorProperty]
	public function getId(): UuidInterface
	{
		return $this->entity->getId();
	}

	#[ObjectToArrayHydratorProperty]
	public function getAmount(): int
	{
		return $this->entity->getAmount();
	}

	public function getEntity(): Entity
	{
		return $this->entity;
	}
}