<?php
namespace Ecommerce\Product;

use Common\Error;
use Common\Translator;

class ProductHasNotEnoughStockError extends Error
{
	/**
	 * @var int|null
	 */
	private $stock;

	/**
	 * @param int|null $stock
	 */
	private function __construct(?int $stock)
	{
		$this->stock = $stock;
	}

	/**
	 * @return ProductHasNotEnoughStockError
	 */
	public static function create(?int $stock = null)
	{
		return new self($stock);
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getCode()
	{
		return 'PRODUCT_HAS_NOT_ENOUGH_STOCK';
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getMessage()
	{
		return $this->stock === null
			? Translator::translate('Nicht genügend lagernd')
			: sprintf(
				Translator::translate('Nicht genügend lagernd (%d Stück lagernd)'),
				$this->stock
			);
	}
}