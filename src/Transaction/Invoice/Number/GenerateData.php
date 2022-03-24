<?php
namespace Ecommerce\Transaction\Invoice\Number;

use Ecommerce\Transaction\Transaction;

class GenerateData
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

	public function setTransaction(Transaction $transaction): GenerateData
	{
		$this->transaction = $transaction;
		return $this;
	}
}