<?php
namespace Ecommerce\Rest\Action\Customer;

use Common\Hydration\ArrayHydratable;
use Ecommerce\Customer\Customer;

class GetSuccessData implements ArrayHydratable
{
	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var Customer
	 */
	private $customer;

	/**
	 * @return GetSuccessData
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
	 * @return GetSuccessData
	 */
	public function setCustomer(Customer $customer): GetSuccessData
	{
		$this->customer = $customer;
		return $this;
	}
}