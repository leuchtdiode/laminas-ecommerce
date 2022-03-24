<?php
namespace Ecommerce\Cart;

use Common\Dto\Dto;
use Common\Hydration\ArrayHydratable;
use Common\Hydration\ObjectToArrayHydratorProperty;
use Ecommerce\Cart\Item\Item;
use Ecommerce\Common\Price;
use Ecommerce\Db\Cart\Entity;
use Ramsey\Uuid\UuidInterface;

class Cart implements Dto, ArrayHydratable
{
	#[ObjectToArrayHydratorProperty]
	private Entity $entity;

	/**
	 * @var Item[]
	 */
	#[ObjectToArrayHydratorProperty]
	private array $items;

	#[ObjectToArrayHydratorProperty]
	private Price $totalPrice;

	/**
	 * @param Item[] $items
	 */
	public function __construct(Entity $entity, array $items, Price $totalPrice)
	{
		$this->entity     = $entity;
		$this->items      = $items;
		$this->totalPrice = $totalPrice;
	}

	#[ObjectToArrayHydratorProperty]
	public function isValid(): bool
	{
		foreach ($this->getItems() as $item)
		{
			if (!$item->isValid())
			{
				return false;
			}
		}

		return true;
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

	/**
	 * @return Item[]
	 */
	public function getItems(): array
	{
		return $this->items;
	}

	public function getEntity(): Entity
	{
		return $this->entity;
	}
}