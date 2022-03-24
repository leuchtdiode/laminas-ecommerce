<?php
namespace Ecommerce\Rest\Action\Customer\Transaction;

use Common\RequestData\Data;
use Common\RequestData\PropertyDefinition\ArrayList;
use Common\RequestData\PropertyDefinition\PropertyDefinition;

class GetListData extends Data
{
	const STATUS = 'status';
	const ORDER  = 'order';

	/**
	 * @return PropertyDefinition[]
	 */
	protected function getDefinitions(): array
	{
		return [
			ArrayList::create()
				->setName(self::STATUS)
				->setRequired(false)
				->setLabel(_('Status')),
			ArrayList::create()
				->setName(self::ORDER)
				->setRequired(false)
				->setLabel(_('Sortierung')),
		];
	}
}