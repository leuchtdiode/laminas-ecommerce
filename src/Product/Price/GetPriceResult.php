<?php
namespace Ecommerce\Product\Price;

use Ecommerce\Common\Price;

class GetPriceResult
{
	private Price $price;

	public function getPrice(): Price
	{
		return $this->price;
	}

	public function setPrice(Price $price): void
	{
		$this->price = $price;
	}
}