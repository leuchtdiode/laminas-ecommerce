<?php
namespace Ecommerce\Db\Product\Attribute\Value\Filter;

use Common\Db\Filter\Equals;

class Value extends Equals
{
	/**
	 * @inheritDoc
	 */
	protected function getField()
	{
		return 't.value';
	}

	/**
	 * @inheritDoc
	 */
	protected function getParameterName()
	{
		return 'productAttributeValueValue';
	}
}