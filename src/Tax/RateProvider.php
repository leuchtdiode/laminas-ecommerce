<?php
namespace Ecommerce\Tax;

interface RateProvider
{
	public function get(GetData $data): GetResult;
}