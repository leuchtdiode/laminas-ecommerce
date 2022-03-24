<?php
namespace Ecommerce\Customer\Auth;

use Common\Util\ArrayCreator;
use Ecommerce\Customer\Customer;
use Mail\Mail\PlaceholderValues;

class ForgotPasswordMailPlaceholderValues implements PlaceholderValues
{
	private Customer $customer;

	private string $hash;

	public static function create(): self
	{
		return new self();
	}

	public function setCustomer(Customer $customer): ForgotPasswordMailPlaceholderValues
	{
		$this->customer = $customer;
		return $this;
	}

	public function setHash(string $hash): ForgotPasswordMailPlaceholderValues
	{
		$this->hash = $hash;
		return $this;
	}

	public function asArray(): array
	{
		return ArrayCreator::create()
			->add($this->customer, 'customer')
			->add($this->hash, 'hash')
			->getArray();
	}
}