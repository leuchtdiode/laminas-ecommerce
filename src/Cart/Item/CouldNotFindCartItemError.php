<?php
namespace Ecommerce\Cart\Item;

use Common\Error;
use Common\Hydration\ObjectToArrayHydratorProperty;
use Common\Translator;

class CouldNotFindCartItemError extends Error
{
	public static function create(): self
	{
		return new self();
	}

	#[ObjectToArrayHydratorProperty]
	public function getCode(): string
	{
		return 'COULD_NOT_FIND_CART_ITEM';
	}

	#[ObjectToArrayHydratorProperty]
	public function getMessage(): string
	{
		return Translator::translate('Warenkorb-Item nicht gefunden');
	}
}