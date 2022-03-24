<?php
namespace Ecommerce\Db\Transaction\Filter;

use Common\Db\Filter\Equals;

class ConsecutiveSuccessNumberInYear extends Equals
{
	protected function getField(): string
	{
		return 't.consecutiveSuccessNumberInYear';
	}
}