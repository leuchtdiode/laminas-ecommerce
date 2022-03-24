<?php
namespace Ecommerce\Rest\Action\Customer;

use Common\Hydration\ArrayHydratable;
use Common\Hydration\ObjectToArrayHydratorProperty;
use Ecommerce\Customer\Customer;

class LoginSuccessData implements ArrayHydratable
{
	#[ObjectToArrayHydratorProperty]
	private string $jwtToken;

	#[ObjectToArrayHydratorProperty]
	private Customer $customer;

	public static function create(): self
	{
		return new self();
	}

	public function getJwtToken(): string
	{
		return $this->jwtToken;
	}

	public function setJwtToken(string $jwtToken): LoginSuccessData
	{
		$this->jwtToken = $jwtToken;
		return $this;
	}

	public function getCustomer(): Customer
	{
		return $this->customer;
	}

	public function setCustomer(Customer $customer): LoginSuccessData
	{
		$this->customer = $customer;
		return $this;
	}
}