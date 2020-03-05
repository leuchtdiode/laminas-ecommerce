<?php
namespace Ecommerce\Payment\PostPayment;

use Ecommerce\Transaction\Transaction;

class SuccessfulData
{
	/**
	 * @var Transaction
	 */
	private $transaction;

	/**
	 * @return SuccessfulData
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
	 * @return SuccessfulData
	 */
	public function setTransaction(Transaction $transaction): SuccessfulData
	{
		$this->transaction = $transaction;
		return $this;
	}
}