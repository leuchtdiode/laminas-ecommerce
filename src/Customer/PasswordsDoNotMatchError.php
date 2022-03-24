<?php
namespace Ecommerce\Customer;

use Common\Error;
use Common\Hydration\ObjectToArrayHydratorProperty;
use Common\Translator;

class PasswordsDoNotMatchError extends Error
{
	public static function create(): self
	{
		return new self();
	}

	#[ObjectToArrayHydratorProperty]
	public function getCode(): string
	{
		return 'PASSWORDS_DO_NOT_MATCH';
	}

	#[ObjectToArrayHydratorProperty]
	public function getMessage(): string
	{
		return Translator::translate('Die Passwörter stimmen nicht überein');
	}
}