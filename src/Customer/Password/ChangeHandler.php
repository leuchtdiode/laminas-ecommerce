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
	private PasswordHandler $passwordHandler;

	private Saver $entitySaver;

	public function __construct(PasswordHandler $passwordHandler, Saver $entitySaver)
	{
		$this->passwordHandler = $passwordHandler;
		$this->entitySaver     = $entitySaver;
	}

	public function change(
		Customer $customer,
		string $oldPassword,
		string $newPassword,
		string $newPasswordVerify
	): ChangeResult
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