<?php
namespace Ecommerce\Transaction\Invoice\Bulk;

use Common\Db\FilterChain;
use Common\Db\OrderChain;
use Ecommerce\Db\Transaction\Filter\CreatedDate as CreatedDateFilter;
use Ecommerce\Db\Transaction\Filter\Status as StatusFilter;
use Ecommerce\Db\Transaction\Order\CreatedDate as CreatedDateOrder;
use Ecommerce\Transaction\Invoice\FileSystemPathProvider;
use Ecommerce\Transaction\Provider as TransactionProvider;
use Ecommerce\Transaction\Status;
use Exception;

class Provider
{
	private array $config;

	private TransactionProvider $transactionProvider;

	private FileSystemPathProvider $fileSystemPathProvider;

	public function __construct(
		array $config,
		TransactionProvider $transactionProvider,
		FileSystemPathProvider $fileSystemPathProvider
	)
	{
		$this->config                 = $config;
		$this->transactionProvider    = $transactionProvider;
		$this->fileSystemPathProvider = $fileSystemPathProvider;
	}

	/**
	 * @throws Exception
	 */
	public function get(GetData $data): GetResult
	{
		$result = new GetResult();

		$transactions = $this->transactionProvider->filter(
			FilterChain::create()
				->addFilter(
					CreatedDateFilter::min(
						$data
							->getDateStart()
							->setTime(0, 0, 0)
					)
				)
				->addFilter(
					CreatedDateFilter::max(
						$data
							->getDateEnd()
							->setTime(23, 59, 59)
					)
				)
				->addFilter(
					StatusFilter::is(
						Status::SUCCESS
					)
				),
			OrderChain::create()
				->addOrder(
					CreatedDateOrder::asc()
				)
		);

		if (!$transactions)
		{
			return $result;
		}

		$tmpPath = tempnam(sys_get_temp_dir(), uniqid());

		$bin = $this->config['ecommerce']['invoice']['bulk']['ghostScriptBin'];

		$command = $bin . ' -q -dNOPAUSE -dBATCH -sDEVICE=pdfwrite -sOutputFile=' . $tmpPath;

		foreach ($transactions as $transaction)
		{
			$command .= ' ' . $this->fileSystemPathProvider->get($transaction);
		}

		shell_exec($command);

		$result->setContent(
			file_get_contents($tmpPath)
		);

		unlink($tmpPath);

		return $result;
	}
}