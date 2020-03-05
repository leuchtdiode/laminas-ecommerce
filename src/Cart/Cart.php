<?php
namespace Ecommerce\Cart;

use Common\Hydration\ArrayHydratable;
use Ecommerce\Cart\Item\Item;
use Ecommerce\Common\Price;
use Ecommerce\Db\Cart\Entity;
use Ramsey\Uuid\UuidInterface;

class Cart implements ArrayHydratable
{
	/**
	 * @var Entity
	 */
	private $entity;

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var Item[]
	 */
	private $items;

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var Price
	 */
	private $totalPrice;

	/**
	 * @param Entity $entity
	 * @param Item[] $items
	 * @param Price $totalPrice
	 */
	public function __construct(Entity $entity, array $items, Price $totalPrice)
	{
		$this->entity     = $entity;
		$this->items      = $items;
		$this->totalPrice = $totalPrice;
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return bool
	 */
	public function isValid()
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

	/**
	 * @return Price
	 */
	public function getTotalPrice(): Price
	{
		return $this->totalPrice;
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return UuidInterface
	 */
	public function getId()
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

	/**
	 * @return Entity
	 */
	public function getEntity(): Entity
	{
		return $this->entity;
	}
}