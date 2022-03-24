<?php
namespace Ecommerce\Db\Transaction\Order;

use Common\Db\Order\AscOrDesc;

class CreatedDate extends AscOrDesc
{
	protected function getField(): string
	{
		return 't.createdDate';
	}
}