<?php
namespace Ecommerce\Payment\MethodHandler;

use Ecommerce\Transaction\Transaction;

class InitData
{
	private Transaction $transaction;

	/**
	 * @return InitData
	 */
	public static function create(): self
	{
		return new self();
	}

	public function getTransaction(): Transaction
	{
		return $this->transaction;
	}

	public function setTransaction(Transaction $transaction): InitData
	{
		$this->transaction = $transaction;
		return $this;
	}
}