<?php
namespace Ecommerce\Tax;

use Common\Country\Country;

class GetData
{
	private Country $country;

	private bool $business;

	public static function create(): self
	{
		return new self();
	}

	public function getCountry(): Country
	{
		return $this->country;
	}

	public function setCountry(Country $country): GetData
	{
		$this->country = $country;
		return $this;
	}

	public function isBusiness(): bool
	{
		return $this->business;
	}

	public function setBusiness(bool $business): GetData
	{
		$this->business = $business;
		return $this;
	}
}