<?php
namespace Ecommerce\Rest\Action\Customer;

use Ecommerce\Address\AddModifyData as AddressAddModifyData;
use Ecommerce\Customer\Auth\RegisterData as CustomerRegisterData;
use Ecommerce\Customer\Auth\RegisterHandler;
use Ecommerce\Rest\Action\Base;
use Ecommerce\Rest\Action\LoginExempt;
use Ecommerce\Rest\Action\Response;
use Exception;

class Register extends Base implements LoginExempt
{
	/**
	 * @var RegisterData
	 */
	private $data;

	/**
	 * @var RegisterHandler
	 */
	private $registerHandler;

	/**
	 * @param RegisterData $data
	 * @param RegisterHandler $registerHandler
	 */
	public function __construct(RegisterData $data, RegisterHandler $registerHandler)
	{
		$this->data            = $data;
		$this->registerHandler = $registerHandler;
	}

	/**
	 * @throws Exception
	 */
	public function executeAction()
	{
		$values = $this->data
			->setRequest($this->getRequest())
			->getValues();

		if ($values->hasErrors())
		{
			return Response::is()
				->unsuccessful()
				->errors($values->getErrors())
				->dispatch();
		}

		$registerResult = $this->registerHandler->register(
			CustomerRegisterData::create()
				->setEmail($values->get(RegisterData::EMAIL)->getValue())
				->setPassword($values->get(RegisterData::PASSWORD)->getValue())
				->setPasswordVerify($values->get(RegisterData::PASSWORD_VERIFY)->getValue())
				->setSalutation($values->get(RegisterData::SALUTATION)->getValue())
				->setTitle(
					$values->get(RegisterData::TITLE)
						? $values->get(RegisterData::TITLE)->getValue()
						: null
				)
				->setFirstName($values->get(RegisterData::FIRST_NAME)->getValue())
				->setLastName($values->get(RegisterData::LAST_NAME)->getValue())
				->setCompany(
					$values->get(RegisterData::COMPANY)
						? $values->get(RegisterData::COMPANY)->getValue()
						: null
				)
				->setTaxNumber(
					$values->get(RegisterData::TAX_NUMBER)
						? $values->get(RegisterData::TAX_NUMBER)->getValue()
						: null
				)
			->setAddressData(
				AddressAddModifyData::create()
					->setZip(
						$values->getRawValue(RegisterData::ADDRESS_ZIP)
					)
					->setCity(
						$values->getRawValue(RegisterData::ADDRESS_CITY)
					)
					->setStreet(
						$values->getRawValue(RegisterData::ADDRESS_STREET)
					)
					->setCountry(
						$values->getRawValue(RegisterData::ADDRESS_COUNTRY)
					)
					->setExtra(
						$values->getRawValue(RegisterData::ADDRESS_STREET_EXTRA)
					)
			)
		);

		if ($registerResult->isSuccess())
		{
			return Response::is()
				->successful()
				->dispatch();
		}

		return Response::is()
			->unsuccessful()
			->errors($registerResult->getErrors())
			->dispatch();
	}
}