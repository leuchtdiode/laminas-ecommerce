<?php
namespace Ecommerce\Customer\Auth;

use Ecommerce\Customer\Customer;
use Ecommerce\Customer\Provider;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Log\Log;

class JwtHandler
{
	const ALGORITHM = 'HS512';

	private array $config;

	private Provider $customerProvider;

	public function __construct(array $config, Provider $customerProvider)
	{
		$this->config           = $config;
		$this->customerProvider = $customerProvider;
	}

	public function generate(Customer $customer): string
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

	public function validate(string $token): JwtValidationResult
	{
		$result = new JwtValidationResult();
		$result->setValid(false);

		try
		{
			$decoded = JWT::decode($token, new Key($this->getKey(), self::ALGORITHM));

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

	private function getKey(): string
	{
		return base64_decode(
			$this->config['ecommerce']['customer']['auth']['jwt']['key']
		);
	}
}