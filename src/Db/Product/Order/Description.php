<?php
namespace Ecommerce\Db\Product\Order;

use Common\Db\Order\AscOrDesc;

class Description extends AscOrDesc
{
	/**
	 * @inheritDoc
	 */
	protected function getField()
	{
		return 't.description';
	}
}