<?php
namespace Ecommerce\Product;

use Common\Error;
use Common\Hydration\ObjectToArrayHydratorProperty;
use Common\Translator;

class ProductHasNotEnoughStockError extends Error
{
	private ?int $stock = null;

	private function __construct(?int $stock)
	{
		$this->stock = $stock;
	}

	public static function create(?int $stock = null): self
	{
		return new self($stock);
	}

	#[ObjectToArrayHydratorProperty]
	public function getCode(): string
	{
		return 'PRODUCT_HAS_NOT_ENOUGH_STOCK';
	}

	#[ObjectToArrayHydratorProperty]
	public function getMessage(): string
	{
		return $this->stock === null
			? Translator::translate('Nicht genügend lagernd')
			: sprintf(
				Translator::translate('Nicht genügend lagernd (%d Stück lagernd)'),
				$this->stock
			);
	}
}