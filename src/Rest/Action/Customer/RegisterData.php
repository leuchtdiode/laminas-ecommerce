<?php
namespace Ecommerce\Rest\Action\Customer;

use Common\RequestData\Data;
use Common\RequestData\PropertyDefinition\Email;
use Common\RequestData\PropertyDefinition\Text;
use Common\Country\Validator as CountryValidator;
use Ecommerce\Customer\SalutationValidator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class RegisterData extends Data
{
	const EMAIL           = 'email';
	const PASSWORD        = 'password';
	const PASSWORD_VERIFY = 'passwordVerify';
	const SALUTATION      = 'salutation';
	const TITLE           = 'title';
	const FIRST_NAME      = 'firstName';
	const LAST_NAME       = 'lastName';
	const COMPANY         = 'company';
	const TAX_NUMBER      = 'taxNumber';

	const ADDRESS_ZIP          = 'address.zip';
	const ADDRESS_CITY         = 'address.city';
	const ADDRESS_STREET       = 'address.street';
	const ADDRESS_STREET_EXTRA = 'address.streetExtra';
	const ADDRESS_COUNTRY      = 'address.country';

	/**
	 * @return array
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 */
	protected function getDefinitions(): array
	{
		return [
			Email::create()
				->setName(self::EMAIL)
				->setLabel(_('E-Mail'))
				->setRequired(true),
			// TODO password validator?
			Text::create()
				->setName(self::PASSWORD)
				->setLabel(_('Passwort'))
				->setRequired(true),
			Text::create()
				->setName(self::PASSWORD_VERIFY)
				->setLabel(_('Passwort-Verifizierung'))
				->setRequired(true),
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
			Text::create()
				->setName(self::ADDRESS_ZIP)
				->setLabel(_('PLZ'))
				->setRequired(true),
			Text::create()
				->setName(self::ADDRESS_CITY)
				->setLabel(_('Ort'))
				->setRequired(true),
			Text::create()
				->setName(self::ADDRESS_STREET)
				->setLabel(_('Straße'))
				->setRequired(true),
			Text::create()
				->setName(self::ADDRESS_STREET_EXTRA)
				->setLabel(_('Straße (Zusatz)'))
				->setRequired(false),
			Text::create()
				->setName(self::ADDRESS_COUNTRY)
				->setLabel(_('Land'))
				->addValidator($this->container->get(CountryValidator::class))
				->setRequired(true),
		];
	}
}