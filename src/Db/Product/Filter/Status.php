<?php
namespace Ecommerce\Db\Product\Filter;

use Common\Db\Filter\Equals;

class Status extends Equals
{
	protected function getField(): string
	{
		return 't.status';
	}
}