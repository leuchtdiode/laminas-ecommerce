<?php
namespace Ecommerce\Payment\PostPayment;

use Ecommerce\Transaction\Transaction;

class UnsuccessfulData
{
	/**
	 * @var Transaction
	 */
	private $transaction;

	/**
	 * @return UnsuccessfulData
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @return Transaction
	 */
	public function getTransaction(): Transaction
	{
		return $this->transaction;
	}

	/**
	 * @param Transaction $transaction
	 * @return UnsuccessfulData
	 */
	public function setTransaction(Transaction $transaction): UnsuccessfulData
	{
		$this->transaction = $transaction;
		return $this;
	}
}