<?php
namespace Ecommerce\Db\Product\Order;

use Common\Db\Order\AscOrDesc;

class Title extends AscOrDesc
{
	/**
	 * @inheritDoc
	 */
	protected function getField()
	{
		return 't.title';
	}
}