<?php
namespace Ecommerce\Customer\Auth;

use Ecommerce\Common\ResultTrait;
use Ecommerce\Customer\Customer;

class LoginResult
{
	use ResultTrait;

	private ?Customer $customer = null;

	private ?string $jwtToken = null;

	public function getCustomer(): ?Customer
	{
		return $this->customer;
	}

	public function setCustomer(?Customer $customer): void
	{
		$this->customer = $customer;
	}

	public function getJwtToken(): ?string
	{
		return $this->jwtToken;
	}

	public function setJwtToken(?string $jwtToken): void
	{
		$this->jwtToken = $jwtToken;
	}
}