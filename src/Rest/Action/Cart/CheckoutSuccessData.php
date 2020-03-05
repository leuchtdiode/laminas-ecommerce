<?php
namespace Ecommerce\Rest\Action\Cart;

use Common\Hydration\ArrayHydratable;

class CheckoutSuccessData implements ArrayHydratable
{
	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var string|null
	 */
	private $redirectUrl;

	/**
	 * @return CheckoutSuccessData
	 */
	public static function create()
	{
		return new self();
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
	 * @return CheckoutSuccessData
	 */
	public function setRedirectUrl(?string $redirectUrl): CheckoutSuccessData
	{
		$this->redirectUrl = $redirectUrl;
		return $this;
	}
}