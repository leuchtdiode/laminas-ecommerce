<?php
namespace Ecommerce\Customer\Auth;

use Common\Error;
use Common\Translator;

class PasswordIncorrectError extends Error
{
	/**
	 * @return PasswordIncorrectError
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getCode()
	{
		return 'CUSTOMER_PASSWORD_INCORRECT';
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getMessage()
	{
		return Translator::translate('Passwort ungültig');
	}
}