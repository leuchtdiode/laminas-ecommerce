<?php
namespace Ecommerce\Cart\Checkout;

use Ecommerce\Common\ResultTrait;
use Ecommerce\Transaction\Transaction;

class CheckoutResult
{
	use ResultTrait;

	private ?Transaction $transaction = null;

	private ?string $redirectUrl = null;

	public function getTransaction(): ?Transaction
	{
		return $this->transaction;
	}

	public function setTransaction(?Transaction $transaction): CheckoutResult
	{
		$this->transaction = $transaction;
		return $this;
	}

	public function getRedirectUrl(): ?string
	{
		return $this->redirectUrl;
	}

	public function setRedirectUrl(?string $redirectUrl): void
	{
		$this->redirectUrl = $redirectUrl;
	}
}