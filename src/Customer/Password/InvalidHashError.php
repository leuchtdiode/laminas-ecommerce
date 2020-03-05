<?php
namespace Ecommerce\Customer\Password;

use Common\Error;
use Common\Translator;

class InvalidHashError extends Error
{
	/**
	 * @return InvalidHashError
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
		return 'INVALID_HASH_ERROR';
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getMessage()
	{
		return Translator::translate('Der Link ist abgelaufen, bitte fordere einen neuen an');
	}
}