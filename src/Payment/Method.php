<?php
namespace Ecommerce\Payment;

use Common\Hydration\ArrayHydratable;
use Ecommerce\Common\IdLabelObject;

class Method implements ArrayHydratable
{
	const PAY_PAL     = 'paypal';
	const AMAZON_PAY  = 'amazon-pay';
	const PRE_PAYMENT = 'pre-payment';
	const MPAY_24     = 'mpay24';
	const WIRECARD    = 'wirecard';

	use IdLabelObject;

	public function isPayPal(): bool
	{
		return $this->is(self::PAY_PAL);
	}

	public function isAmazonPay(): bool
	{
		return $this->is(self::AMAZON_PAY);
	}

	public function isPrePayment(): bool
	{
		return $this->is(self::PRE_PAYMENT);
	}

	public function isMpay24(): bool
	{
		return $this->is(self::MPAY_24);
	}

	public function isWirecard(): bool
	{
		return $this->is(self::WIRECARD);
	}
}