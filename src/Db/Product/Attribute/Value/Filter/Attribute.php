<?php
namespace Ecommerce\Db\Product\Attribute\Value\Filter;

use Common\Db\Filter\Equals;

class Attribute extends Equals
{
	protected function getField(): string
	{
		return 't.attribute';
	}
}