<?php
namespace Ecommerce\Payment\PostPayment;

use Common\Util\ArrayCreator;
use Ecommerce\Customer\Customer;
use Ecommerce\Transaction\Transaction;
use Mail\Mail\PlaceholderValues;

class SuccessMailPlaceholderValues implements PlaceholderValues
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
	 * @return SuccessMailPlaceholderValues
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @param Customer $customer
	 * @return SuccessMailPlaceholderValues
	 */
	public function setCustomer(Customer $customer): SuccessMailPlaceholderValues
	{
		$this->customer = $customer;
		return $this;
	}

	/**
	 * @param Transaction $transaction
	 * @return SuccessMailPlaceholderValues
	 */
	public function setTransaction(Transaction $transaction): SuccessMailPlaceholderValues
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