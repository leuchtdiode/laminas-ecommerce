<?php
namespace Ecommerce\Product\Price;

use Ecommerce\Product\Product;

class GetPriceData
{
	private Product $product;

	private int $quantity;

	public static function create(): self
	{
		return new self();
	}

	public function getProduct(): Product
	{
		return $this->product;
	}

	public function setProduct(Product $product): GetPriceData
	{
		$this->product = $product;
		return $this;
	}

	public function getQuantity(): int
	{
		return $this->quantity;
	}

	public function setQuantity(int $quantity): GetPriceData
	{
		$this->quantity = $quantity;
		return $this;
	}
}