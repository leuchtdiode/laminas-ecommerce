<?php
namespace Ecommerce\Customer\Auth;

use Common\Util\ArrayCreator;
use Ecommerce\Customer\Customer;
use Mail\Mail\PlaceholderValues;

class ForgotPasswordMailPlaceholderValues implements PlaceholderValues
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
	 * @return ForgotPasswordMailPlaceholderValues
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @param Customer $customer
	 * @return ForgotPasswordMailPlaceholderValues
	 */
	public function setCustomer(Customer $customer): ForgotPasswordMailPlaceholderValues
	{
		$this->customer = $customer;
		return $this;
	}

	/**
	 * @param string $hash
	 * @return ForgotPasswordMailPlaceholderValues
	 */
	public function setHash(string $hash): ForgotPasswordMailPlaceholderValues
	{
		$this->hash = $hash;
		return $this;
	}

	/**
	 * @return array
	 */
	public function asArray()
	{
		return ArrayCreator::create()
			->add($this->customer, 'customer')
			->add($this->hash, 'hash')
			->getArray();
	}
}