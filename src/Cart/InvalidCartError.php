<?php
namespace Ecommerce\Cart;

use Common\Error;
use Common\Translator;

class InvalidCartError extends Error
{
	/**
	 * @return InvalidCartError
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
		return 'INVALID_CART';
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getMessage()
	{
		return Translator::translate('Der Warenkorb enthält fehlerhafte Produkte');
	}
}