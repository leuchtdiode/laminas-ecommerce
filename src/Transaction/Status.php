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

	/**
	 * @return bool
	 */
	public function isNew()
	{
		return $this->is(self::NEW);
	}

	/**
	 * @return bool
	 */
	public function isPending()
	{
		return $this->is(self::PENDING);
	}

	/**
	 * @return bool
	 */
	public function isCancelled()
	{
		return $this->is(self::CANCELLED);
	}

	/**
	 * @return bool
	 */
	public function isError()
	{
		return $this->is(self::ERROR);
	}

	/**
	 * @return bool
	 */
	public function isSuccess()
	{
		return $this->is(self::SUCCESS);
	}
}