<?php
namespace Ecommerce\Customer\Auth;

use Common\Error;
use Common\Hydration\ObjectToArrayHydratorProperty;
use Common\Translator;

class CustomerNotActiveError extends Error
{
	public static function create(): self
	{
		return new self();
	}

	#[ObjectToArrayHydratorProperty]
	public function getCode(): string
	{
		return 'CUSTOMER_NOT_ACTIVE';
	}

	#[ObjectToArrayHydratorProperty]
	public function getMessage(): string
	{
		return Translator::translate('Kunde nicht aktiv');
	}
}