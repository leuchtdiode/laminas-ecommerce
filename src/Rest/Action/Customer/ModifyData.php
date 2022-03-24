<?php
namespace Ecommerce\Rest\Action\Customer;

use Common\RequestData\Data;
use Common\RequestData\PropertyDefinition\Text;
use Ecommerce\Customer\SalutationValidator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ModifyData extends Data
{
	const SALUTATION = 'salutation';
	const TITLE      = 'title';
	const FIRST_NAME = 'firstName';
	const LAST_NAME  = 'lastName';
	const COMPANY    = 'company';
	const TAX_NUMBER = 'taxNumber';

	/**
	 * @return array
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 */
	protected function getDefinitions(): array
	{
		return [
			Text::create()
				->setName(self::SALUTATION)
				->setLabel(_('Anrede'))
				->addValidator($this->container->get(SalutationValidator::class))
				->setRequired(true),
			Text::create()
				->setName(self::TITLE)
				->setLabel(_('Titel'))
				->setRequired(false),
			Text::create()
				->setName(self::FIRST_NAME)
				->setLabel(_('Vorname'))
				->setRequired(true),
			Text::create()
				->setName(self::LAST_NAME)
				->setLabel(_('Nachname'))
				->setRequired(true),
			Text::create()
				->setName(self::COMPANY)
				->setLabel(_('Firma'))
				->setRequired(false),
			Text::create()
				->setName(self::TAX_NUMBER)
				->setLabel(_('UID'))
				->setRequired(false),
		];
	}
}