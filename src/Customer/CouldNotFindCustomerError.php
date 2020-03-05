<?php
namespace Ecommerce\Customer;

use Common\Error;
use Common\Translator;

class CouldNotFindCustomerError extends Error
{
	/**
	 * @return CouldNotFindCustomerError
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
		return 'COULD_NOT_FIND_CUSTOMER';
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getMessage()
	{
		return Translator::translate('Kunde konnte nicht gefunden werden');
	}
}