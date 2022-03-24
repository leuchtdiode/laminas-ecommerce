<?php
namespace Ecommerce\Db\Product\Order;

use Common\Db\Order\AscOrDesc;

class Description extends AscOrDesc
{
	protected function getField(): string
	{
		return 't.description';
	}
}