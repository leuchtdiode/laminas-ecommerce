<?php
namespace Ecommerce\Db\Transaction\Filter;

use Common\Db\Filter\Date;

class CreatedDate extends Date
{
	/**
	 * @return string
	 */
	protected function getColumn()
	{
		return 't.createdDate';
	}
}