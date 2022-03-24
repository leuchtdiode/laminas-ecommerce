<?php
namespace Ecommerce\Rest\Action\Customer;

use Common\Hydration\ArrayHydratable;
use Common\Hydration\ObjectToArrayHydratorProperty;
use Ecommerce\Customer\Customer;

class GetSuccessData implements ArrayHydratable
{
	#[ObjectToArrayHydratorProperty]
	private Customer $customer;

	public static function create(): self
	{
		return new self();
	}

	public function getCustomer(): Customer
	{
		return $this->customer;
	}

	public function setCustomer(Customer $customer): GetSuccessData
	{
		$this->customer = $customer;
		return $this;
	}
}