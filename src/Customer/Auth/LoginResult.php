<?php
namespace Ecommerce\Customer\Auth;

use Ecommerce\Common\ResultTrait;
use Ecommerce\Customer\Customer;

class LoginResult
{
	use ResultTrait;

	/**
	 * @var Customer|null
	 */
	private $customer;

	/**
	 * @var string|null
	 */
	private $jwtToken;

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

	/**
	 * @return string|null
	 */
	public function getJwtToken(): ?string
	{
		return $this->jwtToken;
	}

	/**
	 * @param string|null $jwtToken
	 */
	public function setJwtToken(?string $jwtToken): void
	{
		$this->jwtToken = $jwtToken;
	}
}