<?php
namespace Ecommerce\Cart\Item;

use Common\Error;
use Common\Translator;

class CouldNotFindCartItemError extends Error
{
	/**
	 * @return CouldNotFindCartItemError
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
		return 'COULD_NOT_FIND_CART_ITEM';
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getMessage()
	{
		return Translator::translate('Warenkorb-Item nicht gefunden');
	}
}