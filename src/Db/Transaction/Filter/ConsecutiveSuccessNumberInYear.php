<?php
namespace Ecommerce\Db\Transaction\Filter;

use Common\Db\Filter\Equals;

class ConsecutiveSuccessNumberInYear extends Equals
{
	/**
	 * @inheritDoc
	 */
	protected function getField()
	{
		return 't.consecutiveSuccessNumberInYear';
	}

	/**
	 * @inheritDoc
	 */
	protected function getParameterName()
	{
		return 'transactionConsecutiveSuccessNumberInYear';
	}
}