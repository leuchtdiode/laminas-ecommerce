<?php
namespace Ecommerce\Db\Product\Order;

use Common\Db\Order\AscOrDesc;

class Title extends AscOrDesc
{
	protected function getField(): string
	{
		return 't.title';
	}
}