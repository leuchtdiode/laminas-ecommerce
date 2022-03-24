<?php
namespace Ecommerce\Db\Transaction\Filter;

use Common\Db\Filter\Equals;

class Customer extends Equals
{
	protected function getField(): string
	{
		return 't.customer';
	}
}