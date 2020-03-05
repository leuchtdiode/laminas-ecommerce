<?php
namespace Ecommerce\Payment\MethodHandler;

use Ecommerce\Common\ResultTrait;

class InitResult
{
	use ResultTrait;

	/**
	 * @var string|null
	 */
	private $redirectUrl;

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