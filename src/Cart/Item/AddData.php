<?php
namespace Ecommerce\Cart\Item;

use Ecommerce\Cart\Cart;

class AddData
{
	private ?Cart $cart = null;

	private string $productId;

	private int $amount;

	public static function create(): self
	{
		return new self();
	}

	public function getCart(): ?Cart
	{
		return $this->cart;
	}

	public function setCart(?Cart $cart): AddData
	{
		$this->cart = $cart;
		return $this;
	}

	public function getProductId(): string
	{
		return $this->productId;
	}

	public function setProductId(string $productId): AddData
	{
		$this->productId = $productId;
		return $this;
	}

	public function getAmount(): int
	{
		return $this->amount;
	}

	public function setAmount(int $amount): AddData
	{
		$this->amount = $amount;
		return $this;
	}
}