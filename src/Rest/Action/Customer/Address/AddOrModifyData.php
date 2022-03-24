<?php
namespace Ecommerce\Rest\Action\Customer\Address;

use Common\RequestData\Data;
use Common\RequestData\PropertyDefinition\Boolean;
use Common\RequestData\PropertyDefinition\PropertyDefinition;
use Common\RequestData\PropertyDefinition\Text;

class AddOrModifyData extends Data
{
	const COUNTRY          = 'country';
	const ZIP              = 'zip';
	const CITY             = 'city';
	const STREET           = 'street';
	const EXTRA            = 'extra';
	const DEFAULT_BILLING  = 'defaultBilling';
	const DEFAULT_SHIPPING = 'defaultShipping';

	/**
	 * @return PropertyDefinition[]
	 */
	protected function getDefinitions(): array
	{
		return [
			Text::create()
				->setName(self::COUNTRY)
				->setLabel(_('Land'))
				// TODO validator
				->setRequired(true),
			Text::create()
				->setName(self::ZIP)
				->setLabel(_('PLZ'))
				->setRequired(true),
			Text::create()
				->setName(self::CITY)
				->setLabel(_('Ort'))
				->setRequired(true),
			Text::create()
				->setName(self::STREET)
				->setLabel(_('Straße'))
				->setRequired(true),
			Text::create()
				->setName(self::EXTRA)
				->setLabel(_('Straße (Zusatz)'))
				->setRequired(false),
			Boolean::create()
				->setName(self::DEFAULT_BILLING)
				->setLabel(_('Standard-Rechnungsadresse'))
				->setRequired(false),
			Boolean::create()
				->setName(self::DEFAULT_SHIPPING)
				->setLabel(_('Standard-Lieferadresse'))
				->setRequired(false),
		];
	}
}