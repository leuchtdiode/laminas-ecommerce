<?php
namespace Ecommerce\Db\Product\Image\Filter;

use Common\Db\Filter\Equals;

class Product extends Equals
{
	protected function getField(): string
	{
		return 't.product';
	}
}