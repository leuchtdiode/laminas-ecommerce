<?php
namespace Ecommerce\Payment\MethodHandler;

class HandleCallbackResult
{
	private ?string $foreignId = null;

	private string $transactionStatus;

	private bool $redirect = true;

	public function getForeignId(): ?string
	{
		return $this->foreignId;
	}

	public function setForeignId(?string $foreignId): void
	{
		$this->foreignId = $foreignId;
	}

	public function getTransactionStatus(): string
	{
		return $this->transactionStatus;
	}

	public function setTransactionStatus(string $transactionStatus): void
	{
		$this->transactionStatus = $transactionStatus;
	}

	public function isRedirect(): bool
	{
		return $this->redirect;
	}

	public function setRedirect(bool $redirect): void
	{
		$this->redirect = $redirect;
	}
}