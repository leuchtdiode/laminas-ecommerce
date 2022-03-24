<?php
namespace Ecommerce\Db\Address\Filter;

use Common\Db\Filter\Equals;

class Customer extends Equals
{
	protected function getField(): string
	{
		return 't.customer';
	}
}