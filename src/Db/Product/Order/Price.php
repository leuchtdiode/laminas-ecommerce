<?php
namespace Ecommerce\Db\Product\Order;

use Common\Db\Order\AscOrDesc;

class Price extends AscOrDesc
{
	/**
	 * @inheritDoc
	 */
	protected function getField()
	{
		return 't.price';
	}
}