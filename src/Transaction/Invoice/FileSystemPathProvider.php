<?php
namespace Ecommerce\Transaction\Invoice;

use Ecommerce\Transaction\Transaction;
use Exception;
use function file_exists;

class FileSystemPathProvider
{
	private array $config;

	public function __construct(array $config)
	{
		$this->config = $config;
	}

	/**
	 * @throws Exception
	 */
	public function get(Transaction $transaction): string
	{
		$directory = $this->config['ecommerce']['transaction']['invoice']['storeDirectory'] ?? null;

		if (!$directory)
		{
			throw new Exception('Please specify an invoice store directory in config');
		}

		if (!file_exists($directory))
		{
			mkdir($directory, 0775, true);
		}

		return $directory . '/' . $transaction->getId()->toString() . '.pdf';
	}
}