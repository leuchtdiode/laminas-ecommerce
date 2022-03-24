<?php
namespace Ecommerce\Rest\Action\Customer;

use Common\RequestData\Data;
use Common\RequestData\PropertyDefinition\Date;
use Common\RequestData\PropertyDefinition\PropertyDefinition;

class ActivateData extends Data
{
	const CREATED_DATE = 'createdDate';

	/**
	 * @return PropertyDefinition[]
	 */
	protected function getDefinitions(): array
	{
		return [
			Date::create()
				->setName(self::CREATED_DATE)
				->setLabel(_('Erstelldatum'))
				->setRequired(true)
		];
	}
}