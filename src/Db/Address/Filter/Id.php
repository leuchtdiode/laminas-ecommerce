<?php
namespace Ecommerce\Db\Address\Filter;

use Common\Db\Filter\Equals;

class Id extends Equals
{
	protected function getField(): string
	{
		return 't.id';
	}
}