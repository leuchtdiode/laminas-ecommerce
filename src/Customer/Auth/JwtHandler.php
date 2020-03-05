<?php
namespace Ecommerce\Customer\Auth;

use Ecommerce\Customer\Customer;
use Ecommerce\Customer\Provider;
use Exception;
use Firebase\JWT\JWT;
use Log\Log;

class JwtHandler
{
	const ALGORITHM = 'HS512';

	/**
	 * @var array
	 */
	private $config;

	/**
	 * @var Provider
	 */
	private $customerProvider;

	/**
	 * @param array $config
	 * @param Provider $customerProvider
	 */
	public function __construct(array $config, Provider $customerProvider)
	{
		$this->config           = $config;
		$this->customerProvider = $customerProvider;
	}

	/**
	 * @param Customer $customer
	 * @return string
	 */
	public function generate(Customer $customer)
	{
		$tokenId    = base64_encode(
			openssl_random_pseudo_bytes(32)
		);
		$issuedAt   = time();
		$notBefore  = $issuedAt;
		$expire     = $notBefore + $this->config['ecommerce']['customer']['auth']['jwt']['timeoutInSeconds'];
		$serverName = gethostname();

		/*
		 * Create the token as an array
		 */
		$data = [
			'iat'  => $issuedAt,
			'jti'  => $tokenId,
			'iss'  => $serverName,
			'nbf'  => $notBefore,
			'exp'  => $expire,
			'data' => [
				'customerId' => $customer->getId()->toString(),
			],
		];

		$secretKey = $this->getKey();

		return JWT::encode(
			$data,
			$secretKey,
			self::ALGORITHM
		);
	}

	/**
	 * @param $token
	 * @return JwtValidationResult
	 */
	public function validate($token)
	{
		$result = new JwtValidationResult();
		$result->setValid(false);

		try
		{
			$decoded = JWT::decode($token, $this->getKey(), [self::ALGORITHM]);

			$customer = $this->customerProvider->byId(
				$decoded->data->customerId
			);

			if (!$customer)
			{
				return $result;
			}

			$result->setCustomer($customer);
			$result->setValid(true);

			return $result;
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
	private function getKey()
	{
		return base64_decode(
			$this->config['ecommerce']['customer']['auth']['jwt']['key']
		);
	}
}