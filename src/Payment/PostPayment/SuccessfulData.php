<?php
namespace Ecommerce\Payment\PostPayment;

use Ecommerce\Transaction\Transaction;

class SuccessfulData
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

	public function setTransaction(Transaction $transaction): SuccessfulData
	{
		$this->transaction = $transaction;
		return $this;
	}
}