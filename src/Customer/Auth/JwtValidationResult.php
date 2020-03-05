<?php
namespace Ecommerce\Customer\Auth;

use Ecommerce\Customer\Customer;

class JwtValidationResult
{
	/**
	 * @var bool
	 */
	private $valid;

	/**
	 * @var Customer|null
	 */
	private $customer;

	/**
	 * @return bool
	 */
	public function isValid(): bool
	{
		return $this->valid;
	}

	/**
	 * @param bool $valid
	 */
	public function setValid(bool $valid): void
	{
		$this->valid = $valid;
	}

	/**
	 * @return Customer|null
	 */
	public function getCustomer(): ?Customer
	{
		return $this->customer;
	}

	/**
	 * @param Customer|null $customer
	 */
	public function setCustomer(?Customer $customer): void
	{
		$this->customer = $customer;
	}
}