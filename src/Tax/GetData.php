<?php
namespace Ecommerce\Tax;

use Common\Country\Country;

class GetData
{
	/**
	 * @var Country
	 */
	private $country;

	/**
	 * @var bool
	 */
	private $business;

	/**
	 * @return GetData
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @return Country
	 */
	public function getCountry(): Country
	{
		return $this->country;
	}

	/**
	 * @param Country $country
	 * @return GetData
	 */
	public function setCountry(Country $country): GetData
	{
		$this->country = $country;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isBusiness(): bool
	{
		return $this->business;
	}

	/**
	 * @param bool $business
	 * @return GetData
	 */
	public function setBusiness(bool $business): GetData
	{
		$this->business = $business;
		return $this;
	}
}