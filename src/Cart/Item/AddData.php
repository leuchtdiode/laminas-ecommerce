<?php
namespace Ecommerce\Cart\Item;

use Ecommerce\Cart\Cart;

class AddData
{
	/**
	 * @var Cart|null
	 */
	private $cart;

	/**
	 * @var string
	 */
	private $productId;

	/**
	 * @var int
	 */
	private $amount;

	/**
	 * @return AddData
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @return Cart|null
	 */
	public function getCart(): ?Cart
	{
		return $this->cart;
	}

	/**
	 * @param Cart|null $cart
	 * @return AddData
	 */
	public function setCart(?Cart $cart): AddData
	{
		$this->cart = $cart;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getProductId(): string
	{
		return $this->productId;
	}

	/**
	 * @param string $productId
	 * @return AddData
	 */
	public function setProductId(string $productId): AddData
	{
		$this->productId = $productId;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getAmount(): int
	{
		return $this->amount;
	}

	/**
	 * @param int $amount
	 * @return AddData
	 */
	public function setAmount(int $amount): AddData
	{
		$this->amount = $amount;
		return $this;
	}
}