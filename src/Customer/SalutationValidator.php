<?php
namespace Ecommerce\Customer;

use Common\Translator;
use Laminas\Validator\AbstractValidator;

class SalutationValidator extends AbstractValidator
{
	const INVALID = 'invalid';

	private SalutationProvider $salutationProvider;

	public function __construct(SalutationProvider $salutationProvider)
	{
		$this->salutationProvider = $salutationProvider;

		parent::__construct(
			[
				'messageTemplates' => [
					self::INVALID => Translator::translate('Anrede %value% ist ungültig')
				]
			]
		);
	}

	public function isValid($value): bool
	{
		if ($this->salutationProvider->byId($value) === null)
		{
			$this->setValue($value);

			$this->error(self::INVALID);

			return false;
		}

		return true;
	}
}
