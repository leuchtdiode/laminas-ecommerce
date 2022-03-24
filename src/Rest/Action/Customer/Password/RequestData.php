<?php
namespace Ecommerce\Rest\Action\Customer\Password;

use Common\RequestData\Data;
use Common\RequestData\PropertyDefinition\Email;
use Common\RequestData\PropertyDefinition\PropertyDefinition;

class RequestData extends Data
{
	const EMAIL = 'email';

	/**
	 * @return PropertyDefinition[]
	 */
	protected function getDefinitions(): array
	{
		return [
			Email::create()
				->setName(self::EMAIL)
				->setLabel(_('E-Mail'))
				->setRequired(true),
		];
	}
}