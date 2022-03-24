<?php
namespace Ecommerce\Customer\Password;

use Ecommerce\Customer\Customer;

class ResetData
{
	private Customer $customer;

	private string $hash;

	private string $password;

	private string $passwordVerify;

	public static function create(): self
	{
		return new self();
	}

	public function getCustomer(): Customer
	{
		return $this->customer;
	}

	public function setCustomer(Customer $customer): ResetData
	{
		$this->customer = $customer;
		return $this;
	}

	public function getHash(): string
	{
		return $this->hash;
	}

	public function setHash(string $hash): ResetData
	{
		$this->hash = $hash;
		return $this;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	public function setPassword(string $password): ResetData
	{
		$this->password = $password;
		return $this;
	}

	public function getPasswordVerify(): string
	{
		return $this->passwordVerify;
	}

	public function setPasswordVerify(string $passwordVerify): ResetData
	{
		$this->passwordVerify = $passwordVerify;
		return $this;
	}
}