<?php
namespace Ecommerce\Customer;

use Common\Error;
use Common\Hydration\ObjectToArrayHydratorProperty;
use Common\Translator;

class CustomerWithEmailAlreadyExistsError extends Error
{
	private string $email;

	private function __construct(string $email)
	{
		$this->email = $email;
	}

	public static function create(string $email): self
	{
		return new self($email);
	}

	#[ObjectToArrayHydratorProperty]
	public function getCode(): string
	{
		return 'CUSTOMER_WITH_EMAIL_ALREADY_EXISTS_ERROR';
	}

	#[ObjectToArrayHydratorProperty]
	public function getMessage(): string
	{
		return Translator::translate('Die E-Mail Adresse ' . $this->email . ' existiert bereits');
	}
}