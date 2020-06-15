<?php
namespace Ecommerce\Db\Product\Order;

use Common\Db\Order\AscOrDesc;

class Stock extends AscOrDesc
{
	/**
	 * @inheritDoc
	 */
	protected function getField()
	{
		return 't.stock';
	}
}