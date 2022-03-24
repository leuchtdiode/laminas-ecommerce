<?php
namespace Ecommerce\Product;

use Common\Error;
use Common\Hydration\ObjectToArrayHydratorProperty;
use Common\Translator;

class CouldNotFindProductError extends Error
{
	public static function create(): self
	{
		return new self();
	}

	#[ObjectToArrayHydratorProperty]
	public function getCode(): string
	{
		return 'COULD_NOT_FIND_PRODUCT';
	}

	#[ObjectToArrayHydratorProperty]
	public function getMessage(): string
	{
		return Translator::translate('Produkt wurde nicht gefunden');
	}
}