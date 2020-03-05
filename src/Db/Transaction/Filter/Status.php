<?php
namespace Ecommerce\Db\Transaction\Filter;

use Common\Db\Filter\Equals;

class Status extends Equals
{
	/**
	 * @return string
	 */
	protected function getField()
	{
		return 't.status';
	}

	/**
	 * @return string
	 */
	protected function getParameterName()
	{
		return 'status';
	}
}