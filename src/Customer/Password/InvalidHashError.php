<?php
namespace Ecommerce\Customer\Password;

use Common\Error;
use Common\Hydration\ObjectToArrayHydratorProperty;
use Common\Translator;

class InvalidHashError extends Error
{
	public static function create(): self
	{
		return new self();
	}

	#[ObjectToArrayHydratorProperty]
	public function getCode(): string
	{
		return 'INVALID_HASH_ERROR';
	}

	#[ObjectToArrayHydratorProperty]
	public function getMessage(): string
	{
		return Translator::translate('Der Link ist abgelaufen, bitte fordere einen neuen an');
	}
}