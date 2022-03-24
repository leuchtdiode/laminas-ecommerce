<?php
namespace Ecommerce\Rest\Action\Cart\Item;

use Common\RequestData\Data;
use Common\RequestData\PropertyDefinition\Integer;
use Common\RequestData\PropertyDefinition\PropertyDefinition;
use Common\RequestData\PropertyDefinition\Uuid;

class AddData extends Data
{
	const AMOUNT     = 'amount';
	const PRODUCT_ID = 'productId';

	/**
	 * @return PropertyDefinition[]
	 */
	protected function getDefinitions(): array
	{
		return [
			Integer::create()
				->setName(self::AMOUNT)
				->setRequired(true),
			Uuid::create()
				->setName(self::PRODUCT_ID)
				->setRequired(true),
		];
	}
}