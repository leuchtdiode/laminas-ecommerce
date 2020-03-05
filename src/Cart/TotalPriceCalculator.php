<?php
namespace Ecommerce\Cart;

use Ecommerce\Common\Price;
use Ecommerce\Common\PriceCreator;
use Ecommerce\Db\Cart\Item\Entity as CartItemEntity;

class TotalPriceCalculator
{
	/**
	 * @var PriceCreator
	 */
	private $priceCreator;

	/**
	 * @param PriceCreator $priceCreator
	 */
	public function __construct(PriceCreator $priceCreator)
	{
		$this->priceCreator = $priceCreator;
	}

	/**
	 * @param CartItemEntity[] $items
	 * @return Price
	 */
	public function calculate(array $items)
	{
		$totalCents = 0;

		foreach ($items as $item)
		{
			$totalCents += $item->getQuantity() * $item->getProduct()->getPrice();
		}

		return $this->priceCreator->fromCents($totalCents);
	}
}