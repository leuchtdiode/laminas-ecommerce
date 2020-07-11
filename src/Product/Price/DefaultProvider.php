<?php
namespace Ecommerce\Product\Price;

class DefaultProvider implements Provider
{
	/**
	 * @param GetPriceData $data
	 * @return GetPriceResult
	 */
	public function get(GetPriceData $data): GetPriceResult
	{
		$result = new GetPriceResult();

		$product = $data->getProduct();

		$result->setPrice(
			$product->getPrice()
		);

		return $result;
	}
}