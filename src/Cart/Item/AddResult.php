<?php
namespace Ecommerce\Cart\Item;

use Ecommerce\Cart\Cart;
use Ecommerce\Common\ResultTrait;

class AddResult
{
	use ResultTrait;

	private ?Cart $cart = null;

	public function getCart(): ?Cart
	{
		return $this->cart;
	}

	public function setCart(?Cart $cart): void
	{
		$this->cart = $cart;
	}
}