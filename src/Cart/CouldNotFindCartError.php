<?php
namespace Ecommerce\Cart;

use Common\Error;
use Common\Translator;

class CouldNotFindCartError extends Error
{
	/**
	 * @return CouldNotFindCartError
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
		return 'COULD_NOT_FIND_CART';
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getMessage()
	{
		return Translator::translate('Warenkorb nicht gefunden');
	}
}