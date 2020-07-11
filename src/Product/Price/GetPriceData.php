<?php
namespace Ecommerce\Product\Price;

use Ecommerce\Product\Product;

class GetPriceData
{
	/**
	 * @var Product
	 */
	private $product;

	/**
	 * @var int
	 */
	private $quantity;

	/**
	 * @return GetPriceData
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @return Product
	 */
	public function getProduct(): Product
	{
		return $this->product;
	}

	/**
	 * @param Product $product
	 * @return GetPriceData
	 */
	public function setProduct(Product $product): GetPriceData
	{
		$this->product = $product;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getQuantity(): int
	{
		return $this->quantity;
	}

	/**
	 * @param int $quantity
	 * @return GetPriceData
	 */
	public function setQuantity(int $quantity): GetPriceData
	{
		$this->quantity = $quantity;
		return $this;
	}
}