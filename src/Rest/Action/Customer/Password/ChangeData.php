<?php
namespace Ecommerce\Rest\Action\Customer\Password;

use Common\RequestData\Data;
use Common\RequestData\PropertyDefinition\PropertyDefinition;
use Common\RequestData\PropertyDefinition\Text;

class ChangeData extends Data
{
	const PASSWORD            = 'password';
	const PASSWORD_NEW        = 'passwordNew';
	const PASSWORD_NEW_VERIFY = 'passwordNewVerify';

	/**
	 * @return PropertyDefinition[]
	 */
	protected function getDefinitions(): array
	{
		return [
			Text::create()
				->setName(self::PASSWORD)
				->setLabel(_('Aktuelles Passwort'))
				->setRequired(true),
			Text::create()
				->setName(self::PASSWORD_NEW)
				->setLabel(_('Neues Passwort'))
				->setRequired(true),
			Text::create()
				->setName(self::PASSWORD_NEW_VERIFY)
				->setLabel(_('Neues Passwort (Verifizierung)'))
				->setRequired(true),
		];
	}
}