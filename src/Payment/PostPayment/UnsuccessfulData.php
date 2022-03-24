<?php
namespace Ecommerce\Payment\PostPayment;

use Ecommerce\Transaction\Transaction;

class UnsuccessfulData
{
	private Transaction $transaction;

	public static function create(): self
	{
		return new self();
	}

	public function getTransaction(): Transaction
	{
		return $this->transaction;
	}

	public function setTransaction(Transaction $transaction): UnsuccessfulData
	{
		$this->transaction = $transaction;
		return $this;
	}
}