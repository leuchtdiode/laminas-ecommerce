<?php
namespace Ecommerce\Cart\Item;

use Ecommerce\Product\ProductHasNotEnoughStockError;

class Validator
{
	/**
	 * @param Item $item
	 */
	public function validate(Item $item)
	{
		$product = $item->getProduct();

		if (!$product->hasEnoughStock($item->getQuantity()))
		{
			$item->addValidationError(
				ProductHasNotEnoughStockError::create($product->getStock())
			);
		}
	}
}