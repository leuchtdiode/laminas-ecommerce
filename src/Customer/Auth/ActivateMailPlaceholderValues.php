<?php
namespace Ecommerce\Customer\Auth;

use Common\Util\ArrayCreator;
use Ecommerce\Customer\Customer;
use Mail\Mail\PlaceholderValues;

class ActivateMailPlaceholderValues implements PlaceholderValues
{
	/**
	 * @var Customer
	 */
	private $customer;

	/**
	 * @return ActivateMailPlaceholderValues
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @param Customer $customer
	 * @return ActivateMailPlaceholderValues
	 */
	public function setCustomer(Customer $customer): ActivateMailPlaceholderValues
	{
		$this->customer = $customer;
		return $this;
	}

	/**
	 * @return array
	 */
	public function asArray()
	{
		return ArrayCreator::create()
			->add($this->customer, 'customer')
			->getArray();
	}
}