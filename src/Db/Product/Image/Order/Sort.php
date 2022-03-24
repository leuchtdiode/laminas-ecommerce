<?php
namespace Ecommerce\Db\Product\Image\Order;

use Common\Db\Order\AscOrDesc;

class Sort extends AscOrDesc
{
	protected function getField(): string
	{
		return 't.sort';
	}
}