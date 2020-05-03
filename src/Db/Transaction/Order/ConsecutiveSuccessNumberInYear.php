<?php
namespace Ecommerce\Db\Transaction\Order;

use Common\Db\Order\AscOrDesc;

class ConsecutiveSuccessNumberInYear extends AscOrDesc
{
	/**
	 * @return string
	 */
	protected function getField()
	{
		return 't.consecutiveSuccessNumberInYear';
	}
}