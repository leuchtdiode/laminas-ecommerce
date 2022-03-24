<?php
namespace Ecommerce\Payment\MethodHandler;

use Ecommerce\Common\ResultTrait;

class InitResult
{
	use ResultTrait;

	private ?string $redirectUrl = null;

	public function getRedirectUrl(): ?string
	{
		return $this->redirectUrl;
	}

	public function setRedirectUrl(?string $redirectUrl): void
	{
		$this->redirectUrl = $redirectUrl;
	}
}