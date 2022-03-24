<?php
namespace Ecommerce\Cart;

use Ecommerce\Cart\Item\Creator as CartItemCreator;
use Ecommerce\Common\EntityDtoCreator;
use Ecommerce\Db\Cart\Entity;
use Ecommerce\Db\Cart\Item\Entity as CartItemEntity;

class Creator implements EntityDtoCreator
{
	private TotalPriceCalculator $totalPriceCalculator;

	private CartItemCreator $cartItemCreator;

	public function __construct(TotalPriceCalculator $totalPriceCalculator)
	{
		$this->totalPriceCalculator = $totalPriceCalculator;
	}

	public function setCartItemCreator(CartItemCreator $cartItemCreator): void
	{
		$this->cartItemCreator = $cartItemCreator;
	}

	/**
	 * @param Entity $entity
	 */
	public function byEntity($entity): Cart
	{
		$items = $entity
			->getItems()
			->toArray();

		return new Cart(
			$entity,
			array_map(
				function (CartItemEntity $entity)
				{
					return $this->cartItemCreator->byEntity($entity);
				},
				$items
			),
			$this->totalPriceCalculator->calculate($items)
		);
	}
}