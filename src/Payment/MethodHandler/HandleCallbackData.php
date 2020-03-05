<?php
namespace Ecommerce\Payment\MethodHandler;

use Ecommerce\Transaction\Transaction;
use Laminas\Http\Request;

class HandleCallbackData
{
	/**
	 * @var Transaction
	 */
	private $transaction;

	/**
	 * @var string
	 */
	private $type;

	/**
	 * @var Request
	 */
	private $request;

	/**
	 * @return HandleCallbackData
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
	 * @return HandleCallbackData
	 */
	public function setTransaction(Transaction $transaction): HandleCallbackData
	{
		$this->transaction = $transaction;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getType(): string
	{
		return $this->type;
	}

	/**
	 * @param string $type
	 * @return HandleCallbackData
	 */
	public function setType(string $type): HandleCallbackData
	{
		$this->type = $type;
		return $this;
	}

	/**
	 * @return Request
	 */
	public function getRequest(): Request
	{
		return $this->request;
	}

	/**
	 * @param Request $request
	 * @return HandleCallbackData
	 */
	public function setRequest(Request $request): HandleCallbackData
	{
		$this->request = $request;
		return $this;
	}
}
