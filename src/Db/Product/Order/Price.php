<?php
namespace Ecommerce\Db\Product\Order;

use Common\Db\Order\AscOrDesc;

class Price extends AscOrDesc
{
	protected function getField(): string
	{
		return 't.price';
	}
}