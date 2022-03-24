<?php
namespace Ecommerce\Transaction\Invoice\Number;

class GenerateResult
{
	private string $invoiceNumber;

	public function getInvoiceNumber(): string
	{
		return $this->invoiceNumber;
	}

	public function setInvoiceNumber(string $invoiceNumber): void
	{
		$this->invoiceNumber = $invoiceNumber;
	}
}