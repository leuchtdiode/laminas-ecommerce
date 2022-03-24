<?php
namespace Ecommerce\Payment\PostPayment;

use Common\Util\ArrayCreator;
use Ecommerce\Customer\Customer;
use Ecommerce\Transaction\Transaction;
use Mail\Mail\PlaceholderValues;

class UnsuccessfulMailPlaceholderValues implements PlaceholderValues
{
	private Customer $customer;

	private Transaction $transaction;

	public static function create(): self
	{
		return new self();
	}

	public function setCustomer(Customer $customer): UnsuccessfulMailPlaceholderValues
	{
		$this->customer = $customer;
		return $this;
	}

	public function setTransaction(Transaction $transaction): UnsuccessfulMailPlaceholderValues
	{
		$this->transaction = $transaction;
		return $this;
	}

	public function asArray(): array
	{
		return ArrayCreator::create()
			->add($this->customer, 'customer')
			->add($this->transaction, 'transaction')
			->getArray();
	}
}