<?php
namespace Ecommerce\Cart\Item;

use Ecommerce\Cart\Cart;
use Ecommerce\Common\ResultTrait;

class AddResult
{
	use ResultTrait;

	/**
	 * @var Cart|null
	 */
	private $cart;

	/**
	 * @return Cart|null
	 */
	public function getCart(): ?Cart
	{
		return $this->cart;
	}

	/**
	 * @param Cart|null $cart
	 */
	public function setCart(?Cart $cart): void
	{
		$this->cart = $cart;
	}
}