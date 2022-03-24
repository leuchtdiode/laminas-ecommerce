<?php
namespace Ecommerce\Customer\Auth;

use Common\Util\ArrayCreator;
use Ecommerce\Customer\Customer;
use Mail\Mail\PlaceholderValues;

class ActivateMailPlaceholderValues implements PlaceholderValues
{
	private Customer $customer;

	public static function create(): self
	{
		return new self();
	}

	public function setCustomer(Customer $customer): ActivateMailPlaceholderValues
	{
		$this->customer = $customer;
		return $this;
	}

	public function asArray(): array
	{
		return ArrayCreator::create()
			->add($this->customer, 'customer')
			->getArray();
	}
}