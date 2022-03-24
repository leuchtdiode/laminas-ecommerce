<?php
namespace Ecommerce\Db\Product\Order;

use Common\Db\Order\AscOrDesc;

class CreatedDate extends AscOrDesc
{
	protected function getField(): string
	{
		return 't.createdDate';
	}
}