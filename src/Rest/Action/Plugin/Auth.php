<?php
namespace Ecommerce\Rest\Action\Plugin;

use Ecommerce\Customer\Auth\JwtHandler;
use Ecommerce\Customer\Auth\JwtValidationResult;
use Ecommerce\Customer\Customer;
use Laminas\Mvc\Controller\Plugin\AbstractPlugin;

class Auth extends AbstractPlugin
{
	/**
	 * @var JwtHandler
	 */
	private $jwtHandler;

	/**
	 * @param JwtHandler $jwtHandler
	 */
	public function __construct(JwtHandler $jwtHandler)
	{
		$this->jwtHandler = $jwtHandler;
	}

	/**
	 * @return $this
	 */
	public function __invoke()
	{
		return $this;
	}

	/**
	 * @param Customer $customer
	 */
	public function generateJwtToken(Customer $customer)
	{
		return $this->jwtHandler->generate($customer);
	}

	/**
	 * @param string $token
	 * @return JwtValidationResult
	 */
	public function validateJwtToken($token)
	{
		return $this->jwtHandler->validate($token);
	}
}
