<?php
namespace Ecommerce\Rest\Action\Cart;

use Common\Hydration\ArrayHydratable;
use Ecommerce\Cart\Cart;

class GetSuccessData implements ArrayHydratable
{
	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var Cart
	 */
	private $cart;

	/**
	 * @return GetSuccessData
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @return Cart
	 */
	public function getCart(): Cart
	{
		return $this->cart;
	}

	/**
	 * @param Cart $cart
	 * @return GetSuccessData
	 */
	public function setCart(Cart $cart): GetSuccessData
	{
		$this->cart = $cart;
		return $this;
	}
}