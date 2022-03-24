<?php
namespace Ecommerce\Db\Transaction\Filter;

use Common\Db\Filter\Date;

class CreatedDate extends Date
{
	protected function getColumn(): string
	{
		return 't.createdDate';
	}
}