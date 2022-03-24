<?php
namespace Ecommerce\Customer\Auth;

use Ecommerce\Customer\Customer;

class JwtValidationResult
{
	private bool $valid;

	private ?Customer $customer = null;

	public function isValid(): bool
	{
		return $this->valid;
	}

	public function setValid(bool $valid): void
	{
		$this->valid = $valid;
	}

	public function getCustomer(): ?Customer
	{
		return $this->customer;
	}

	public function setCustomer(?Customer $customer): void
	{
		$this->customer = $customer;
	}
}