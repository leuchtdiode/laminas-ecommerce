<?php
namespace Ecommerce\Customer\Auth;

use Ecommerce\Customer\Customer;
use Ecommerce\Db\Customer\Saver;
use Exception;
use Log\Log;

class ForgotPasswordHandler
{
	/**
	 * @var ForgotPasswordMailSender
	 */
	private $mailSender;

	/**
	 * @var Saver
	 */
	private $entitySaver;

	/**
	 * @param ForgotPasswordMailSender $mailSender
	 * @param Saver $entitySaver
	 */
	public function __construct(ForgotPasswordMailSender $mailSender, Saver $entitySaver)
	{
		$this->mailSender  = $mailSender;
		$this->entitySaver = $entitySaver;
	}

	/**
	 * @param Customer $customer
	 * @return ForgotPasswordResult
	 */
	public function forgotPassword(Customer $customer)
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

	/**
	 * @return string
	 */
	private function generateHash()
	{
		return bin2hex(
			openssl_random_pseudo_bytes(10)
		);
	}
}