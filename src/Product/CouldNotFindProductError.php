<?php
namespace Ecommerce\Product;

use Common\Error;
use Common\Translator;

class CouldNotFindProductError extends Error
{
	/**
	 * @return CouldNotFindProductError
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
		return 'COULD_NOT_FIND_PRODUCT';
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getMessage()
	{
		return Translator::translate('Produkt wurde nicht gefunden');
	}
}