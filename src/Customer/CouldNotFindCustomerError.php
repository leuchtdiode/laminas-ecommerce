<?php
namespace Ecommerce\Customer;

use Common\Error;
use Common\Hydration\ObjectToArrayHydratorProperty;
use Common\Translator;

class CouldNotFindCustomerError extends Error
{
	public static function create(): self
	{
		return new self();
	}

	#[ObjectToArrayHydratorProperty]
	public function getCode(): string
	{
		return 'COULD_NOT_FIND_CUSTOMER';
	}

	#[ObjectToArrayHydratorProperty]
	public function getMessage(): string
	{
		return Translator::translate('Kunde konnte nicht gefunden werden');
	}
}