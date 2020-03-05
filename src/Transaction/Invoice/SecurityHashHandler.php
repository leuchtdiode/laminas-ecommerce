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
	/**
	 * @var array
	 */
	private $config;

	/**
	 * @var EncryptDecryptHandler
	 */
	private $encryptDecryptHandler;

	/**
	 * @param array $config
	 * @param EncryptDecryptHandler $encryptDecryptHandler
	 */
	public function __construct(array $config, EncryptDecryptHandler $encryptDecryptHandler)
	{
		$this->config                = $config;
		$this->encryptDecryptHandler = $encryptDecryptHandler;
	}

	/**
	 * @param int $lifeTimeInSeconds
	 * @return string
	 * @throws Exception
	 */
	public function get(int $lifeTimeInSeconds)
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
	 * @param $hash
	 * @return bool
	 * @throws Exception
	 */
	public function valid($hash)
	{
		$data = unserialize(
			$this->encryptDecryptHandler->decrypt($hash, $this->getOptions())
		);

		return $data && $data['validUntil'] >= time();
	}

	/**
	 * @return EncryptDecryptOptions
	 */
	private function getOptions()
	{
		$config = $this->config['ecommerce']['transaction']['invoice']['securityHash'];

		return EncryptDecryptOptions::create()
			->setKey($config['key'])
			->setIv($config['iv']);
	}
}
