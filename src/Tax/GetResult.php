<?php
namespace Ecommerce\Tax;

class GetResult
{
	private int $rate;

	public function setRate(int $rate): GetResult
	{
		$this->rate = $rate;
		return $this;
	}

	public function getRate(): int
	{
		return $this->rate;
	}
}