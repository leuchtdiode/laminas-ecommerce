<?php
namespace Ecommerce\Tax;

class GetResult
{
	/**
	 * @var int
	 */
	private $rate;

	/**
	 * @param int $rate
	 * @return GetResult
	 */
	public function setRate(int $rate): GetResult
	{
		$this->rate = $rate;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getRate(): int
	{
		return $this->rate;
	}
}