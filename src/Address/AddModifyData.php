<?php
namespace Ecommerce\Address;

use Ecommerce\Customer\Customer;

class AddModifyData
{
	/**
	 * @var Address|null
	 */
	private $address;

	/**
	 * @var Customer
	 */
	private $customer;

	/**
	 * @var string
	 */
	private $country;

	/**
	 * @var string
	 */
	private $zip;

	/**
	 * @var string
	 */
	private $city;

	/**
	 * @var string
	 */
	private $street;

	/**
	 * @var string|null
	 */
	private $extra;

	/**
	 * @var bool
	 */
	private $defaultBilling;

	/**
	 * @var bool
	 */
	private $defaultShipping;

	/**
	 * @return AddModifyData
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @return Address|null
	 */
	public function getAddress(): ?Address
	{
		return $this->address;
	}

	/**
	 * @param Address|null $address
	 * @return AddModifyData
	 */
	public function setAddress(?Address $address): AddModifyData
	{
		$this->address = $address;
		return $this;
	}

	/**
	 * @return Customer
	 */
	public function getCustomer(): Customer
	{
		return $this->customer;
	}

	/**
	 * @param Customer $customer
	 * @return AddModifyData
	 */
	public function setCustomer(Customer $customer): AddModifyData
	{
		$this->customer = $customer;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getCountry(): string
	{
		return $this->country;
	}

	/**
	 * @param string $country
	 * @return AddModifyData
	 */
	public function setCountry(string $country): AddModifyData
	{
		$this->country = $country;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getZip(): string
	{
		return $this->zip;
	}

	/**
	 * @param string $zip
	 * @return AddModifyData
	 */
	public function setZip(string $zip): AddModifyData
	{
		$this->zip = $zip;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getCity(): string
	{
		return $this->city;
	}

	/**
	 * @param string $city
	 * @return AddModifyData
	 */
	public function setCity(string $city): AddModifyData
	{
		$this->city = $city;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getStreet(): string
	{
		return $this->street;
	}

	/**
	 * @param string $street
	 * @return AddModifyData
	 */
	public function setStreet(string $street): AddModifyData
	{
		$this->street = $street;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getExtra(): ?string
	{
		return $this->extra;
	}

	/**
	 * @param string|null $extra
	 * @return AddModifyData
	 */
	public function setExtra(?string $extra): AddModifyData
	{
		$this->extra = $extra;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isDefaultBilling(): bool
	{
		return $this->defaultBilling;
	}

	/**
	 * @param bool $defaultBilling
	 * @return AddModifyData
	 */
	public function setDefaultBilling(bool $defaultBilling): AddModifyData
	{
		$this->defaultBilling = $defaultBilling;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isDefaultShipping(): bool
	{
		return $this->defaultShipping;
	}

	/**
	 * @param bool $defaultShipping
	 * @return AddModifyData
	 */
	public function setDefaultShipping(bool $defaultShipping): AddModifyData
	{
		$this->defaultShipping = $defaultShipping;
		return $this;
	}
}