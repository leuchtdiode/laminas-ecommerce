<?php
namespace Ecommerce\Cart;

use Ecommerce\Cart\Item\Validator as ItemValidator;

class Validator
{
	/**
	 * @var ItemValidator
	 */
	private $itemValidator;

	/**
	 * @param ItemValidator $itemValidator
	 */
	public function __construct(ItemValidator $itemValidator)
	{
		$this->itemValidator = $itemValidator;
	}

	/**
	 * @param Cart $cart
	 */
	public function validate(Cart $cart)
	{
		foreach ($cart->getItems() as $item)
		{
			$this->itemValidator->validate($item);
		}
	}
}