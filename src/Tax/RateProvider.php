<?php
namespace Ecommerce\Tax;

interface RateProvider
{
	/**
	 * @param GetData $data
	 * @return GetResult
	 */
	public function get(GetData $data): GetResult;
}