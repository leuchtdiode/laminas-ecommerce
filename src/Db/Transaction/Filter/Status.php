<?php
namespace Ecommerce\Db\Transaction\Filter;

use Common\Db\Filter\Equals;

class Status extends Equals
{
	protected function getField(): string
	{
		return 't.status';
	}
}