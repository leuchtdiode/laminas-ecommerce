<?php
namespace Ecommerce\Customer;

use Common\Hydration\ArrayHydratable;
use Ecommerce\Common\IdLabelObject;

class Status implements ArrayHydratable
{
	const PENDING_VERIFICATION = 'pending-verification';
	const ACTIVE               = 'active';

	use IdLabelObject;

	/**
	 * @return bool
	 */
	public function isPendingVerification()
	{
		return $this->is(self::PENDING_VERIFICATION);
	}

	/**
	 * @return bool
	 */
	public function isActive()
	{
		return $this->is(self::ACTIVE);
	}
}