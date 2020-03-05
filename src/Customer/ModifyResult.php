<?php
namespace Ecommerce\Customer;

use Ecommerce\Common\ResultTrait;

class ModifyResult
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