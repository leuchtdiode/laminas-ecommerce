<?php
namespace Ecommerce\Customer\Auth;

use Ecommerce\Common\ResultTrait;
use Ecommerce\Customer\Customer;

class RegisterResult
{
	use ResultTrait;

	/**
	 * @var Customer|null
	 */
	private $customer;

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