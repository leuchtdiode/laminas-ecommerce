<?php
namespace Ecommerce\Product\Price;

interface Provider
{
	/**
	 * @param GetPriceData $data
	 * @return GetPriceResult
	 */
	public function get(GetPriceData $data): GetPriceResult;
}