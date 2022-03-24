<?php
namespace Ecommerce\Rest\Action\Cart\Item;

use Common\Hydration\ArrayHydratable;
use Common\Hydration\ObjectToArrayHydratorProperty;
use Ecommerce\Cart\Cart;

class AddSuccessData implements ArrayHydratable
{
	#[ObjectToArrayHydratorProperty]
	private Cart $cart;

	public static function create(): self
	{
		return new self();
	}

	public function getCart(): Cart
	{
		return $this->cart;
	}

	public function setCart(Cart $cart): AddSuccessData
	{
		$this->cart = $cart;
		return $this;
	}
}