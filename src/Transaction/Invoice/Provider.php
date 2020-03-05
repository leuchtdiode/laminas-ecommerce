<?php
namespace Ecommerce\Transaction\Invoice;

use Ecommerce\Transaction\Transaction;
use Exception;

class Provider
{
	/**
	 * @var FileSystemPathProvider
	 */
	private $fileSystemPathProvider;

	/**
	 * @param FileSystemPathProvider $fileSystemPathProvider
	 */
	public function __construct(FileSystemPathProvider $fileSystemPathProvider)
	{
		$this->fileSystemPathProvider = $fileSystemPathProvider;
	}

	/**
	 * @param Transaction $transaction
	 * @return Invoice
	 * @throws Exception
	 */
	public function get(Transaction $transaction)
	{
		$path = $this->fileSystemPathProvider->get($transaction);

		return Invoice::create()
			->setFileName($transaction->getReferenceNumber() . '.pdf')
			->setMimeType('application/pdf')
			->setContent(file_get_contents($path));
	}
}