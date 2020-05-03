<?php
namespace Ecommerce\Transaction\Invoice\Number;

class GenerateResult
{
	/**
	 * @var string
	 */
	private $invoiceNumber;

	/**
	 * @return string
	 */
	public function getInvoiceNumber(): string
	{
		return $this->invoiceNumber;
	}

	/**
	 * @param string $invoiceNumber
	 */
	public function setInvoiceNumber(string $invoiceNumber): void
	{
		$this->invoiceNumber = $invoiceNumber;
	}
}