<?php
namespace Ecommerce\Customer;

use Common\Error;
use Common\Translator;

class PasswordsDoNotMatchError extends Error
{
	/**
	 * @return PasswordsDoNotMatchError
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
		return 'PASSWORDS_DO_NOT_MATCH';
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getMessage()
	{
		return Translator::translate('Die Passwörter stimmen nicht überein');
	}
}