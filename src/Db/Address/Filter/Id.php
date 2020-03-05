<?php
namespace Ecommerce\Db\Address\Filter;

use Common\Db\Filter\Equals;

class Id extends Equals
{
	/**
	 * @return string
	 */
	protected function getField()
	{
		return 't.id';
	}

	/**
	 * @return string
	 */
	protected function getParameterName()
	{
		return 'addressId';
	}
}