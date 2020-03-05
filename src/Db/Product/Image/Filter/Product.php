<?php
namespace Ecommerce\Db\Product\Image\Filter;

use Common\Db\Filter\Equals;

class Product extends Equals
{
	/**
	 * @return string
	 */
	protected function getField()
	{
		return 't.product';
	}

	/**
	 * @return string
	 */
	protected function getParameterName()
	{
		return 'product';
	}
}