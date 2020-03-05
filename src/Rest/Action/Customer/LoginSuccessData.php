<?php
namespace Ecommerce\Rest\Action\Customer;

use Common\Hydration\ArrayHydratable;
use Ecommerce\Customer\Customer;

class LoginSuccessData implements ArrayHydratable
{
	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var string
	 */
	private $jwtToken;

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var Customer
	 */
	private $customer;

	/**
	 * @return LoginSuccessData
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @return string
	 */
	public function getJwtToken(): string
	{
		return $this->jwtToken;
	}

	/**
	 * @param string $jwtToken
	 * @return LoginSuccessData
	 */
	public function setJwtToken(string $jwtToken): LoginSuccessData
	{
		$this->jwtToken = $jwtToken;
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
	 * @return LoginSuccessData
	 */
	public function setCustomer(Customer $customer): LoginSuccessData
	{
		$this->customer = $customer;
		return $this;
	}
}