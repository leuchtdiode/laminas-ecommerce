<?php
namespace Ecommerce\Db\Transaction\Order;

use Common\Db\Order\AscOrDesc;

class ConsecutiveSuccessNumberInYear extends AscOrDesc
{
	protected function getField(): string
	{
		return 't.consecutiveSuccessNumberInYear';
	}
}