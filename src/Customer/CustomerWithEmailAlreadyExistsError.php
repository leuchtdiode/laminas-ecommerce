<?php
namespace Ecommerce\Customer;

use Common\Error;
use Common\Translator;

class CustomerWithEmailAlreadyExistsError extends Error
{
	/**
	 * @var string
	 */
	private $email;

	/**
	 * @param string $email
	 */
	private function __construct(string $email)
	{
		$this->email = $email;
	}

	/**
	 * @return CustomerWithEmailAlreadyExistsError
	 */
	public static function create($email)
	{
		return new self($email);
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getCode()
	{
		return 'CUSTOMER_WITH_EMAIL_ALREADY_EXISTS_ERROR';
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getMessage()
	{
		return Translator::translate('Die E-Mail Adresse ' . $this->email . ' existiert bereits');
	}
}