<?php
namespace Ecommerce\Customer\Auth;

use Ecommerce\Common\ResultTrait;
use Ecommerce\Customer\Customer;

class RegisterResult
{
	use ResultTrait;

	private ?Customer $customer = null;

	public function getCustomer(): ?Customer
	{
		return $this->customer;
	}

	public function setCustomer(?Customer $customer): void
	{
		$this->customer = $customer;
	}
}