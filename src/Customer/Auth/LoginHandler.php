<?php
namespace Ecommerce\Customer\Auth;

use Ecommerce\Customer\CouldNotFindCustomerError;
use Ecommerce\Customer\Provider;

class LoginHandler
{
	private Provider $customerProvider;

	private JwtHandler $jwtHandler;

	public function __construct(Provider $customerProvider, JwtHandler $jwtHandler)
	{
		$this->customerProvider = $customerProvider;
		$this->jwtHandler       = $jwtHandler;
	}

	public function login(LoginData $data): LoginResult
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