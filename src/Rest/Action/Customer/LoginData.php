<?php
namespace Ecommerce\Rest\Action\Customer;

use Common\RequestData\Data;
use Common\RequestData\PropertyDefinition\Email;
use Common\RequestData\PropertyDefinition\Text;

class LoginData extends Data
{
	const EMAIL    = 'email';
	const PASSWORD = 'password';

	protected function getDefinitions(): array
	{
		return [
			Email::create()
				->setName(self::EMAIL)
				->setRequired(true),
			Text::create()
				->setName(self::PASSWORD)
				->setRequired(true),
		];
	}
}