<?php
namespace Ecommerce\Rest\Action\Invoice;

use Common\RequestData\Data;
use Common\RequestData\PropertyDefinition\Date;
use Common\RequestData\PropertyDefinition\PropertyDefinition;

class BulkData extends Data
{
	const DATE_START = 'dateStart';
	const DATE_END   = 'dateEnd';
	
	/**
	 * @return PropertyDefinition[]
	 */
	protected function getDefinitions(): array
	{
		return [
			Date::create()
				->setName(self::DATE_START)
				->setRequired(true),
			Date::create()
				->setName(self::DATE_END)
				->setRequired(true),
		];
	}
}