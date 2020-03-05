<?php
namespace Ecommerce\Customer\Password;

use Ecommerce\Customer\Auth\PasswordHandler;
use Ecommerce\Customer\Auth\PasswordIncorrectError;
use Ecommerce\Customer\Customer;
use Ecommerce\Customer\PasswordsDoNotMatchError;
use Ecommerce\Db\Customer\Saver;
use Exception;
use Log\Log;

class ChangeHandler
{
	/**
	 * @var PasswordHandler
	 */
	private $passwordHandler;

	/**
	 * @var Saver
	 */
	private $entitySaver;

	/**
	 * @param PasswordHandler $passwordHandler
	 * @param Saver $entitySaver
	 */
	public function __construct(PasswordHandler $passwordHandler, Saver $entitySaver)
	{
		$this->passwordHandler = $passwordHandler;
		$this->entitySaver     = $entitySaver;
	}

	/**
	 * @param Customer $customer
	 * @param $oldPassword
	 * @param $newPassword
	 * @param $newPasswordVerify
	 * @return ChangeResult
	 */
	public function change(Customer $customer, $oldPassword, $newPassword, $newPasswordVerify)
	{
		$result = new ChangeResult();
		$result->setSuccess(false);

		if (!$this->passwordHandler->verify($oldPassword, $customer->getPassword()))
		{
			$result->addError(PasswordIncorrectError::create());

			return $result;
		}

		if ($newPassword !== $newPasswordVerify)
		{
			$result->addError(PasswordsDoNotMatchError::create());

			return $result;
		}

		try
		{
			$entity = $customer->getEntity();
			$entity->setPassword(
				$this->passwordHandler->hash($newPassword)
			);

			$this->entitySaver->save($entity);

			$result->setSuccess(true);
		}
		catch (Exception $ex)
		{
			Log::error($ex);
		}

		return $result;
	}
}