<?php
namespace Ecommerce\Db\Product\Attribute\Value\Filter;

use Common\Db\Filter\Equals;

class Value extends Equals
{
	protected function getField(): string
	{
		return 't.value';
	}
}