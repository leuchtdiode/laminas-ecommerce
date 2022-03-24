<?php
namespace Ecommerce\Transaction\Invoice;

use Common\Encryption\EncryptDecryptHandler;
use Common\Encryption\EncryptDecryptOptions;
use DateTime;
use Exception;
use function serialize;
use function unserialize;

class SecurityHashHandler
{
	private array $config;

	private EncryptDecryptHandler $encryptDecryptHandler;

	public function __construct(array $config, EncryptDecryptHandler $encryptDecryptHandler)
	{
		$this->config                = $config;
		$this->encryptDecryptHandler = $encryptDecryptHandler;
	}

	/**
	 * @throws Exception
	 */
	public function get(int $lifeTimeInSeconds): string
	{
		$data = serialize(
			[
				'validUntil' => (new DateTime())
					->modify('+' . $lifeTimeInSeconds . ' seconds')
					->getTimestamp()
			]
		);

		return $this->encryptDecryptHandler->encrypt($data, $this->getOptions());
	}

	/**
	 * @throws Exception
	 */
	public function valid(string $hash): bool
	{
		$data = unserialize(
			$this->encryptDecryptHandler->decrypt($hash, $this->getOptions())
		);

		return $data && $data['validUntil'] >= time();
	}

	private function getOptions(): EncryptDecryptOptions
	{
		$config = $this->config['ecommerce']['transaction']['invoice']['securityHash'];

		return EncryptDecryptOptions::create()
			->setKey($config['key'])
			->setIv($config['iv']);
	}
}
