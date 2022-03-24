<?php
namespace Ecommerce\Rest\Action\Plugin;

use Ecommerce\Customer\Auth\JwtHandler;
use Ecommerce\Customer\Auth\JwtValidationResult;
use Ecommerce\Customer\Customer;
use Laminas\Mvc\Controller\Plugin\AbstractPlugin;

class Auth extends AbstractPlugin
{
	private JwtHandler $jwtHandler;

	public function __construct(JwtHandler $jwtHandler)
	{
		$this->jwtHandler = $jwtHandler;
	}

	public function __invoke(): self
	{
		return $this;
	}

	public function generateJwtToken(Customer $customer): string
	{
		return $this->jwtHandler->generate($customer);
	}

	public function validateJwtToken(string $token): JwtValidationResult
	{
		return $this->jwtHandler->validate($token);
	}
}
