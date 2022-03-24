<?php
namespace Ecommerce\Customer;

use Ecommerce\Common\ResultTrait;

class ModifyResult
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