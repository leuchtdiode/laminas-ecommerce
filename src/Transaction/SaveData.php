<?php
namespace Ecommerce\Transaction;

class SaveData
{
	private Transaction $transaction;

	private string $status;

	public static function create(): self
	{
		return new self();
	}

	public function getTransaction(): Transaction
	{
		return $this->transaction;
	}

	public function setTransaction(Transaction $transaction): SaveData
	{
		$this->transaction = $transaction;
		return $this;
	}

	public function getStatus(): string
	{
		return $this->status;
	}

	public function setStatus(string $status): SaveData
	{
		$this->status = $status;
		return $this;
	}
}