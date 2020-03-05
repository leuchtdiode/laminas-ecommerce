<?php
namespace Ecommerce\Rest\Action\Cart\Item;

use Common\Hydration\ArrayHydratable;
use Ecommerce\Cart\Cart;

class AddSuccessData implements ArrayHydratable
{
	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var Cart
	 */
	private $cart;

	/**
	 * @return AddSuccessData
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
	 * @return AddSuccessData
	 */
	public function setCart(Cart $cart): AddSuccessData
	{
		$this->cart = $cart;
		return $this;
	}
}