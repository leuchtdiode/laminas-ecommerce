<?php
namespace Ecommerce\Db\Product\Attribute\Value\Filter;

use Common\Db\Filter\Equals;

class Attribute extends Equals
{
	/**
	 * @inheritDoc
	 */
	protected function getField()
	{
		return 't.attribute';
	}

	/**
	 * @inheritDoc
	 */
	protected function getParameterName()
	{
		return 'productAttributeValueAttribute';
	}
}