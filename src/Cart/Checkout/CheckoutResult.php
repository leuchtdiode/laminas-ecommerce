<?php
namespace Ecommerce\Cart\Checkout;

use Ecommerce\Common\ResultTrait;
use Ecommerce\Transaction\Transaction;

class CheckoutResult
{
	use ResultTrait;

	/**
	 * @var Transaction|null
	 */
	private $transaction;

	/**
	 * @var string|null
	 */
	private $redirectUrl;

	/**
	 * @return Transaction|null
	 */
	public function getTransaction(): ?Transaction
	{
		return $this->transaction;
	}

	/**
	 * @param Transaction|null $transaction
	 * @return CheckoutResult
	 */
	public function setTransaction(?Transaction $transaction): CheckoutResult
	{
		$this->transaction = $transaction;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getRedirectUrl(): ?string
	{
		return $this->redirectUrl;
	}

	/**
	 * @param string|null $redirectUrl
	 */
	public function setRedirectUrl(?string $redirectUrl): void
	{
		$this->redirectUrl = $redirectUrl;
	}
}