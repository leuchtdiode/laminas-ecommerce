<?php
namespace Ecommerce\Transaction\Invoice\Number;

class DefaultGenerator implements Generator
{
	private array $config;

	public function __construct(array $config)
	{
		$this->config = $config;
	}

	public function generate(GenerateData $data): GenerateResult
	{
		$result = new GenerateResult();

		$transaction = $data->getTransaction();
		$year        = $transaction
			->getCreatedDate()
			->format('Y');

		$config = $this->config['ecommerce']['invoice']['number']['default'];

		$invoiceNumber = str_replace(
			[
				'%year%',
				'%year2Digits%',
				'%consecutiveNumber%',
			],
			[
				$year,
				substr($year, 2, 2),
				str_pad(
					$transaction->getConsecutiveSuccessNumberInYear(),
					$config['consecutiveNumberLength'],
					0,
					STR_PAD_LEFT
				),
			],
			$config['template']
		);

		$result->setInvoiceNumber($invoiceNumber);

		return $result;
	}
}