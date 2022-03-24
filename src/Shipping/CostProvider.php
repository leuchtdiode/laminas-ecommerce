<?php
namespace Ecommerce\Shipping;

interface CostProvider
{
	public function get(GetData $data): ?int;
}