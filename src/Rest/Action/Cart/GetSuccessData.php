<?php
namespace Ecommerce\Rest\Action\Cart;

use Common\Hydration\ArrayHydratable;
use Common\Hydration\ObjectToArrayHydratorProperty;
use Ecommerce\Cart\Cart;

class GetSuccessData implements ArrayHydratable
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

	public function setCart(Cart $cart): GetSuccessData
	{
		$this->cart = $cart;
		return $this;
	}
}