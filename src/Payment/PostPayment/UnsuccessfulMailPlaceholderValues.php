<?php
namespace Ecommerce\Payment\PostPayment;

use Common\Util\ArrayCreator;
use Ecommerce\Customer\Customer;
use Ecommerce\Transaction\Transaction;
use Mail\Mail\PlaceholderValues;

class UnsuccessfulMailPlaceholderValues implements PlaceholderValues
{
	/**
	 * @var Customer
	 */
	private $customer;

	/**
	 * @var Transaction
	 */
	private $transaction;

	/**
	 * @return UnsuccessfulMailPlaceholderValues
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @param Customer $customer
	 * @return UnsuccessfulMailPlaceholderValues
	 */
	public function setCustomer(Customer $customer): UnsuccessfulMailPlaceholderValues
	{
		$this->customer = $customer;
		return $this;
	}

	/**
	 * @param Transaction $transaction
	 * @return UnsuccessfulMailPlaceholderValues
	 */
	public function setTransaction(Transaction $transaction): UnsuccessfulMailPlaceholderValues
	{
		$this->transaction = $transaction;
		return $this;
	}

	/**
	 * @return array
	 */
	public function asArray()
	{
		return ArrayCreator::create()
			->add($this->customer, 'customer')
			->add($this->transaction, 'transaction')
			->getArray();
	}
}