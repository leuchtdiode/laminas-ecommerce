<?php
namespace Ecommerce\Customer\Auth;

use Ecommerce\Customer\CouldNotFindCustomerError;
use Ecommerce\Customer\Provider;

class LoginHandler
{
	/**
	 * @var Provider
	 */
	private $customerProvider;

	/**
	 * @var JwtHandler
	 */
	private $jwtHandler;

	/**
	 * @param Provider $customerProvider
	 * @param JwtHandler $jwtHandler
	 */
	public function __construct(Provider $customerProvider, JwtHandler $jwtHandler)
	{
		$this->customerProvider = $customerProvider;
		$this->jwtHandler       = $jwtHandler;
	}

	/**
	 * @param LoginData $data
	 * @return LoginResult
	 */
	public function login(LoginData $data)
	{
		$result = new LoginResult();
		$result->setSuccess(false);

		$customer = $this->customerProvider->byEmail(
			$data->getEmail()
		);

		if (!$customer)
		{
			$result->addError(CouldNotFindCustomerError::create());

			return $result;
		}

		if (!$customer->getStatus()->isActive())
		{
			$result->addError(CustomerNotActiveError::create());

			return $result;
		}

		if (!password_verify($data->getPassword(), $customer->getPassword()))
		{
			$result->addError(PasswordIncorrectError::create());

			return $result;
		}

		$result->setSuccess(true);
		$result->setJwtToken(
			$this->jwtHandler->generate($customer)
		);
		$result->setCustomer($customer);

		return $result;
	}
}