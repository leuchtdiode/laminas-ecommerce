<?php
namespace Ecommerce\Payment\MethodHandler;

use Ecommerce\Transaction\Transaction;
use Laminas\Http\Request;

class HandleCallbackData
{
	private Transaction $transaction;

	private string $type;

	private Request $request;

	public static function create(): self
	{
		return new self();
	}

	public function getTransaction(): Transaction
	{
		return $this->transaction;
	}

	public function setTransaction(Transaction $transaction): HandleCallbackData
	{
		$this->transaction = $transaction;
		return $this;
	}

	public function getType(): string
	{
		return $this->type;
	}

	public function setType(string $type): HandleCallbackData
	{
		$this->type = $type;
		return $this;
	}

	public function getRequest(): Request
	{
		return $this->request;
	}

	public function setRequest(Request $request): HandleCallbackData
	{
		$this->request = $request;
		return $this;
	}
}
