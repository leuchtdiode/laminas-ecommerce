<?php
namespace Ecommerce\Rest\Action\Customer\Password;

use Common\RequestData\Data;
use Common\RequestData\PropertyDefinition\PropertyDefinition;
use Common\RequestData\PropertyDefinition\Text;

class ResetData extends Data
{
	const HASH            = 'hash';
	const PASSWORD        = 'password';
	const PASSWORD_VERIFY = 'passwordVerify';

	/**
	 * @return PropertyDefinition[]
	 */
	protected function getDefinitions(): array
	{
		return [
			Text::create()
				->setName(self::HASH)
				->setLabel(_('Hash'))
				->setRequired(true),
			Text::create()
				->setName(self::PASSWORD)
				->setLabel(_('Neues Passwort'))
				->setRequired(true),
			Text::create()
				->setName(self::PASSWORD_VERIFY)
				->setLabel(_('Neues Passwort (Verifizierung)'))
				->setRequired(true),
		];
	}
}