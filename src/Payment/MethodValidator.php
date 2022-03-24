<?php
namespace Ecommerce\Payment;

use Common\Translator;
use Laminas\Validator\AbstractValidator;

class MethodValidator extends AbstractValidator
{
	const INVALID = 'invalid';

	private MethodProvider $methodProvider;

	public function __construct(MethodProvider $methodProvider)
	{
		$this->methodProvider = $methodProvider;

		parent::__construct(
			[
				'messageTemplates' => [
					self::INVALID => Translator::translate('Ungültige Zahlungsmethode %value%'),
				],
			]
		);
	}

	public function isValid($value): bool
	{
		if ($this->methodProvider->byId($value) === null)
		{
			$this->setValue($value);

			$this->error(self::INVALID);

			return false;
		}

		return true;
	}
}
