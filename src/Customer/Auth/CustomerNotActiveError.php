<?php
namespace Ecommerce\Customer\Auth;

use Common\Error;
use Common\Translator;

class CustomerNotActiveError extends Error
{
	/**
	 * @return CustomerNotActiveError
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
		return 'CUSTOMER_NOT_ACTIVE';
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getMessage()
	{
		return Translator::translate('Kunde nicht aktiv');
	}
}