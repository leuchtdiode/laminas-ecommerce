<?php
namespace Ecommerce\Transaction\Invoice;

use Ecommerce\Transaction\Transaction;

class GenerateData
{
	/**
	 * @var Transaction
	 */
	private $transaction;

	/**
	 * @return GenerateData
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
	 * @return GenerateData
	 */
	public function setTransaction(Transaction $transaction): GenerateData
	{
		$this->transaction = $transaction;
		return $this;
	}
}