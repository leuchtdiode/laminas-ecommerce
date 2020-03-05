<?php
namespace Ecommerce\Payment\MethodHandler;

use Ecommerce\Transaction\Transaction;

class InitData
{
	/**
	 * @var Transaction
	 */
	private $transaction;

	/**
	 * @return InitData
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
	 * @return InitData
	 */
	public function setTransaction(Transaction $transaction): InitData
	{
		$this->transaction = $transaction;
		return $this;
	}
}