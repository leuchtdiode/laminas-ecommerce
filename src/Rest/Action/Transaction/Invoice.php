<?php
namespace Ecommerce\Rest\Action\Transaction;

use Ecommerce\Rest\Action\Base;
use Ecommerce\Rest\Action\LoginExempt;
use Ecommerce\Transaction\Invoice\FileSystemPathProvider;
use Ecommerce\Transaction\Invoice\SecurityHashHandler;
use Ecommerce\Transaction\Provider as TransactionProvider;
use Exception;

class Invoice extends Base implements LoginExempt
{
	/**
	 * @var TransactionProvider
	 */
	private $transactionProvider;

	/**
	 * @var FileSystemPathProvider
	 */
	private $fileSystemPathProvider;

	/**
	 * @var SecurityHashHandler
	 */
	private $securityHashHandler;

	/**
	 * @param TransactionProvider $transactionProvider
	 * @param FileSystemPathProvider $fileSystemPathProvider
	 * @param SecurityHashHandler $securityHashHandler
	 */
	public function __construct(
		TransactionProvider $transactionProvider,
		FileSystemPathProvider $fileSystemPathProvider,
		SecurityHashHandler $securityHashHandler
	)
	{
		$this->transactionProvider = $transactionProvider;
		$this->fileSystemPathProvider = $fileSystemPathProvider;
		$this->securityHashHandler = $securityHashHandler;
	}

	/**
	 * @throws Exception
	 */
	public function executeAction()
	{
		$response = $this->getResponse();

		$transaction = $this->transactionProvider->byId(
			$this
				->params()
				->fromRoute('transactionId')
		);

		if (!$transaction)
		{
			return $this->notFound();
		}

		$hash = $this
			->params()
			->fromQuery('sec');

		if (!$hash || !$this->securityHashHandler->valid($hash))
		{
			return $this->forbidden();
		}

		$path = $this->fileSystemPathProvider->get($transaction);

		if (!file_exists($path))
		{
			return $this->notFound();
		}

		$pdf = file_get_contents($path);

		$response
			->getHeaders()
			->addHeaders(
				[
					'Content-type' => 'application/pdf;charset=utf-8'
				]
			);

		$response->setContent($pdf);

		return $response;
	}
}