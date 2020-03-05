<?php
namespace Ecommerce\Customer\Password;

use Ecommerce\Customer\Auth\PasswordHandler;
use Ecommerce\Customer\PasswordsDoNotMatchError;
use Ecommerce\Db\Customer\Saver;
use Exception;
use Log\Log;

class ResetHandler
{
	/**
	 * @var Saver
	 */
	private $entitySaver;

	/**
	 * @var PasswordHandler
	 */
	private $passwordHandler;

	/**
	 * @param Saver $entitySaver
	 * @param PasswordHandler $passwordHandler
	 */
	public function __construct(Saver $entitySaver, PasswordHandler $passwordHandler)
	{
		$this->entitySaver     = $entitySaver;
		$this->passwordHandler = $passwordHandler;
	}

	/**
	 * @param ResetData $data
	 * @return ResetResult
	 */
	public function reset(ResetData $data)
	{
		$result = new ResetResult();
		$result->setSuccess(false);

		$customer = $data->getCustomer();

		if ($customer->getForgotPasswordHash() !== $data->getHash())
		{
			$result->addError(InvalidHashError::create());

			return $result;
		}

		if ($data->getPassword() !== $data->getPasswordVerify())
		{
			$result->addError(PasswordsDoNotMatchError::create());

			return $result;
		}

		try
		{
			$entity = $customer->getEntity();
			$entity->setForgotPasswordHash(null);
			$entity->setPassword(
				$this->passwordHandler->hash($data->getPassword())
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