<?php
namespace Ecommerce\Customer;

use Common\Hydration\ArrayHydratable;
use Ecommerce\Common\IdLabelObject;

class Status implements ArrayHydratable
{
	const PENDING_VERIFICATION = 'pending-verification';
	const ACTIVE               = 'active';

	use IdLabelObject;

	public function isPendingVerification(): bool
	{
		return $this->is(self::PENDING_VERIFICATION);
	}

	public function isActive(): bool
	{
		return $this->is(self::ACTIVE);
	}
}