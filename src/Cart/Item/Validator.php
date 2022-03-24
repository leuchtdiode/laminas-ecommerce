<?php
namespace Ecommerce\Cart\Item;

use Ecommerce\Product\ProductHasNotEnoughStockError;

class Validator
{
	public function validate(Item $item): void
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