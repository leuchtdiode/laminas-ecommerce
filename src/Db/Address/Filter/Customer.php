<?php
namespace Ecommerce\Db\Address\Filter;

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
		return 'addressCustomer';
	}
}