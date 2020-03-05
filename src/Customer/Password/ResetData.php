<?php
namespace Ecommerce\Customer\Password;

use Ecommerce\Customer\Customer;

class ResetData
{
	/**
	 * @var Customer
	 */
	private $customer;

	/**
	 * @var string
	 */
	private $hash;

	/**
	 * @var string
	 */
	private $password;

	/**
	 * @var string
	 */
	private $passwordVerify;

	/**
	 * @return ResetData
	 */
	public static function create()
	{
		return new self();
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
	 * @return ResetData
	 */
	public function setCustomer(Customer $customer): ResetData
	{
		$this->customer = $customer;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getHash(): string
	{
		return $this->hash;
	}

	/**
	 * @param string $hash
	 * @return ResetData
	 */
	public function setHash(string $hash): ResetData
	{
		$this->hash = $hash;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPassword(): string
	{
		return $this->password;
	}

	/**
	 * @param string $password
	 * @return ResetData
	 */
	public function setPassword(string $password): ResetData
	{
		$this->password = $password;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPasswordVerify(): string
	{
		return $this->passwordVerify;
	}

	/**
	 * @param string $passwordVerify
	 * @return ResetData
	 */
	public function setPasswordVerify(string $passwordVerify): ResetData
	{
		$this->passwordVerify = $passwordVerify;
		return $this;
	}
}