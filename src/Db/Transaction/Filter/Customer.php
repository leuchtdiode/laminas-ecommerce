<?php
namespace Ecommerce\Db\Transaction\Filter;

use Common\Db\Filter\Equals;

class Customer extends Equals
{
	/**
	 * @return string
	 */
	protected function getField()
	{
		return 't.customer';
	}

	/**
	 * @return string
	 */
	protected function getParameterName()
	{
		return 'customer';
	}
}