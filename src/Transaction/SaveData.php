<?php
namespace Ecommerce\Transaction;

class SaveData
{
	/**
	 * @var Transaction
	 */
	private $transaction;

	/**
	 * @var string
	 */
	private $status;

	/**
	 * @return SaveData
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
	 * @return SaveData
	 */
	public function setTransaction(Transaction $transaction): SaveData
	{
		$this->transaction = $transaction;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getStatus(): string
	{
		return $this->status;
	}

	/**
	 * @param string $status
	 * @return SaveData
	 */
	public function setStatus(string $status): SaveData
	{
		$this->status = $status;
		return $this;
	}
}