<?php
namespace Ecommerce\Transaction;

use Common\Hydration\ArrayHydratable;
use Ecommerce\Common\IdLabelObject;

class Status implements ArrayHydratable
{
	const NEW       = 'new';
	const PENDING   = 'pending';
	const CANCELLED = 'cancelled';
	const ERROR     = 'error';
	const SUCCESS   = 'success';

	use IdLabelObject;

	public function isNew(): bool
	{
		return $this->is(self::NEW);
	}

	public function isPending(): bool
	{
		return $this->is(self::PENDING);
	}

	public function isCancelled(): bool
	{
		return $this->is(self::CANCELLED);
	}

	public function isError(): bool
	{
		return $this->is(self::ERROR);
	}

	public function isSuccess(): bool
	{
		return $this->is(self::SUCCESS);
	}
}