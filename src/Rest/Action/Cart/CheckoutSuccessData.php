<?php
namespace Ecommerce\Rest\Action\Cart;

use Common\Hydration\ArrayHydratable;
use Common\Hydration\ObjectToArrayHydratorProperty;

class CheckoutSuccessData implements ArrayHydratable
{
	#[ObjectToArrayHydratorProperty]
	private ?string $redirectUrl = null;

	public static function create(): self
	{
		return new self();
	}

	public function getRedirectUrl(): ?string
	{
		return $this->redirectUrl;
	}

	public function setRedirectUrl(?string $redirectUrl): CheckoutSuccessData
	{
		$this->redirectUrl = $redirectUrl;
		return $this;
	}
}