<?php
namespace Ecommerce\Product\Price;

interface Provider
{
	public function get(GetPriceData $data): GetPriceResult;
}