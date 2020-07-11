<?php
namespace Ecommerce\Product\Price;

use Ecommerce\Common\Price;

class GetPriceResult
{
	/**
	 * @var Price
	 */
	private $price;

	/**
	 * @return Price
	 */
	public function getPrice(): Price
	{
		return $this->price;
	}

	/**
	 * @param Price $price
	 */
	public function setPrice(Price $price): void
	{
		$this->price = $price;
	}
}