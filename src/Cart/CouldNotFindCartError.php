<?php
namespace Ecommerce\Cart;

use Common\Error;
use Common\Hydration\ObjectToArrayHydratorProperty;
use Common\Translator;

class CouldNotFindCartError extends Error
{
	public static function create(): self
	{
		return new self();
	}

	#[ObjectToArrayHydratorProperty]
	public function getCode(): string
	{
		return 'COULD_NOT_FIND_CART';
	}

	#[ObjectToArrayHydratorProperty]
	public function getMessage(): string
	{
		return Translator::translate('Warenkorb nicht gefunden');
	}
}