<?php
namespace Ecommerce\Payment;

use Common\Hydration\ArrayHydratable;
use Ecommerce\Common\IdLabelObject;

class Method implements ArrayHydratable
{
	const PAY_PAL     = 'paypal';
	const AMAZON_PAY  = 'amazon-pay';
	const PRE_PAYMENT = 'pre-payment';
	const WIRECARD    = 'wirecard';

	use IdLabelObject;

	/**
	 * @return bool
	 */
	public function isPayPal()
	{
		return $this->is(self::PAY_PAL);
	}

	/**
	 * @return bool
	 */
	public function isAmazonPay()
	{
		return $this->is(self::AMAZON_PAY);
	}

	/**
	 * @return bool
	 */
	public function isPrePayment()
	{
		return $this->is(self::PRE_PAYMENT);
	}
}