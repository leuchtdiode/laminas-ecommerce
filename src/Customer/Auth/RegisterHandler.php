<?php
namespace Ecommerce\Customer\Auth;

use Ecommerce\Address\AddModifyHandler as AddressAddModifyHandler;
use Ecommerce\Common\DtoCreatorProvider;
use Ecommerce\Customer\CustomerWithEmailAlreadyExistsError;
use Ecommerce\Customer\Provider;
use Ecommerce\Db\Customer\Entity;
use Ecommerce\Db\Customer\Saver;
use Exception;
use Log\Log;

class RegisterHandler
{
	/**
	 * @var Provider
	 */
	private $customerProvider;

	/**
	 * @var DtoCreatorProvider
	 */
	private $dtoCreatorProvider;

	/**
	 * @var Saver
	 */
	private $entitySaver;

	/**
	 * @var PasswordHandler
	 */
	private $passwordHandler;

	/**
	 * @var ActivateMailSender
	 */
	private $activateMailSender;

	/**
	 * @var AddressAddModifyHandler
	 */
	private $addressAddModifyHandler;

	/**
	 * @param Provider $customerProvider
	 * @param DtoCreatorProvider $dtoCreatorProvider
	 * @param Saver $entitySaver
	 * @param PasswordHandler $passwordHandler
	 * @param ActivateMailSender $activateMailSender
	 * @param AddressAddModifyHandler $addressAddModifyHandler
	 */
	public function __construct(
		Provider $customerProvider,
		DtoCreatorProvider $dtoCreatorProvider,
		Saver $entitySaver,
		PasswordHandler $passwordHandler,
		ActivateMailSender $activateMailSender,
		AddressAddModifyHandler $addressAddModifyHandler
	)
	{
		$this->customerProvider        = $customerProvider;
		$this->dtoCreatorProvider      = $dtoCreatorProvider;
		$this->entitySaver             = $entitySaver;
		$this->passwordHandler         = $passwordHandler;
		$this->activateMailSender      = $activateMailSender;
		$this->addressAddModifyHandler = $addressAddModifyHandler;
	}

	/**
	 * @param RegisterData $data
	 * @return RegisterResult
	 */
	public function register(RegisterData $data)
	{
		$result = new RegisterResult();
		$result->setSuccess(false);

		$email = $data->getEmail();

		if ($this->customerProvider->byEmail($email))
		{
			$result->addError(CustomerWithEmailAlreadyExistsError::create($email));

			return $result;
		}

		if ($data->getPassword() !== $data->getPasswordVerify())
		{
			$result->addError(CustomerWithEmailAlreadyExistsError::create($email));

			return $result;
		}

		try
		{
			$entity = new Entity();
			$entity->setEmail($email);
			$entity->setPassword(
				$this->passwordHandler->hash($data->getPassword())
			);
			$entity->setSalutation($data->getSalutation());
			$entity->setFirstName($data->getFirstName());
			$entity->setLastName($data->getLastName());
			$entity->setTitle($data->getTitle());
			$entity->setCompany($data->getCompany());
			$entity->setTaxNumber($data->getTaxNumber());

			$this->entitySaver->save($entity);

			$customer = $this->dtoCreatorProvider
				->getCustomerCreator()
				->byEntity($entity);

			// add address as default billing and shipping
			$addressAddModifyData = $data->getAddressData();
			$addressAddModifyData->setCustomer($customer);
			$addressAddModifyData->setDefaultBilling(true);
			$addressAddModifyData->setDefaultShipping(true);

			$addAddressResult = $this->addressAddModifyHandler->addOrModify($addressAddModifyData);

			if (!$addAddressResult->isSuccess())
			{
				$result->setErrors($addAddressResult->getErrors());

				return $result;
			}

			if ($this->activateMailSender->send($customer))
			{
				$result->setSuccess(true);
				$result->setCustomer($customer);
			}
		}
		catch (Exception $ex)
		{
			Log::error($ex);
		}

		return $result;
	}
}