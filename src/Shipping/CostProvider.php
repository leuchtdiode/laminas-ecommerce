<?php
namespace Ecommerce\Shipping;

interface CostProvider
{
	/**
	 * @param GetData $data
	 * @return int|null
	 */
	public function get(GetData $data): ?int;
}