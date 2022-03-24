<?php
namespace Ecommerce\Customer\Auth;

use Ecommerce\Customer\Customer;
use Ecommerce\Db\Customer\Saver;
use Exception;
use Log\Log;

class ForgotPasswordHandler
{
	private ForgotPasswordMailSender $mailSender;

	private Saver $entitySaver;

	public function __construct(ForgotPasswordMailSender $mailSender, Saver $entitySaver)
	{
		$this->mailSender  = $mailSender;
		$this->entitySaver = $entitySaver;
	}

	public function forgotPassword(Customer $customer): ForgotPasswordResult
	{
		$result = new ForgotPasswordResult();

		try
		{
			$entity = $customer->getEntity();
			$entity->setForgotPasswordHash(
				$hash = $this->generateHash()
			);

			$this->entitySaver->save($entity);

			$result->setSuccess(
				$this->mailSender->send($customer, $hash)
			);
		}
		catch (Exception $ex)
		{
			Log::error($ex);
		}

		return $result;
	}

	private function generateHash(): string
	{
		return bin2hex(
			openssl_random_pseudo_bytes(10)
		);
	}
}