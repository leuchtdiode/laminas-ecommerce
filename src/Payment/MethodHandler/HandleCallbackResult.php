<?php
namespace Ecommerce\Payment\MethodHandler;

class HandleCallbackResult
{
	/**
	 * @var string|null
	 */
	private $foreignId;

	/**
	 * @var string
	 */
	private $transactionStatus;

	/**
	 * @return string|null
	 */
	public function getForeignId(): ?string
	{
		return $this->foreignId;
	}

	/**
	 * @param string|null $foreignId
	 */
	public function setForeignId(?string $foreignId): void
	{
		$this->foreignId = $foreignId;
	}

	/**
	 * @return string
	 */
	public function getTransactionStatus(): string
	{
		return $this->transactionStatus;
	}

	/**
	 * @param string $transactionStatus
	 */
	public function setTransactionStatus(string $transactionStatus): void
	{
		$this->transactionStatus = $transactionStatus;
	}
}