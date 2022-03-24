<?php
namespace Ecommerce\Address;

use Ecommerce\Customer\Customer;

class AddModifyData
{
	private ?Address $address = null;

	private Customer $customer;

	private string $country;

	private string $zip;

	private string $city;

	private string $street;

	private ?string $extra = null;

	private bool $defaultBilling;

	private bool $defaultShipping;

	public static function create(): self
	{
		return new self();
	}

	public function getAddress(): ?Address
	{
		return $this->address;
	}

	public function setAddress(?Address $address): AddModifyData
	{
		$this->address = $address;
		return $this;
	}

	public function getCustomer(): Customer
	{
		return $this->customer;
	}

	public function setCustomer(Customer $customer): AddModifyData
	{
		$this->customer = $customer;
		return $this;
	}

	public function getCountry(): string
	{
		return $this->country;
	}

	public function setCountry(string $country): AddModifyData
	{
		$this->country = $country;
		return $this;
	}

	public function getZip(): string
	{
		return $this->zip;
	}

	public function setZip(string $zip): AddModifyData
	{
		$this->zip = $zip;
		return $this;
	}

	public function getCity(): string
	{
		return $this->city;
	}

	public function setCity(string $city): AddModifyData
	{
		$this->city = $city;
		return $this;
	}

	public function getStreet(): string
	{
		return $this->street;
	}

	public function setStreet(string $street): AddModifyData
	{
		$this->street = $street;
		return $this;
	}

	public function getExtra(): ?string
	{
		return $this->extra;
	}

	public function setExtra(?string $extra): AddModifyData
	{
		$this->extra = $extra;
		return $this;
	}

	public function isDefaultBilling(): bool
	{
		return $this->defaultBilling;
	}

	public function setDefaultBilling(bool $defaultBilling): AddModifyData
	{
		$this->defaultBilling = $defaultBilling;
		return $this;
	}

	public function isDefaultShipping(): bool
	{
		return $this->defaultShipping;
	}

	public function setDefaultShipping(bool $defaultShipping): AddModifyData
	{
		$this->defaultShipping = $defaultShipping;
		return $this;
	}
}