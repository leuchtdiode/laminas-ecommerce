<?php
namespace Ecommerce\Db\Product\Order;

use Common\Db\Order\AscOrDesc;

class Stock extends AscOrDesc
{
	protected function getField(): string
	{
		return 't.stock';
	}
}