<?php
namespace Ecommerce\Db\Product\Image\Order;

use Common\Db\Order\AscOrDesc;

class Sort extends AscOrDesc
{
	/**
	 * @return string
	 */
	protected function getField()
	{
		return 't.sort';
	}
}