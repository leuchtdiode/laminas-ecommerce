<?php
namespace Ecommerce\Transaction\Invoice;

use Ecommerce\Common\ResultTrait;

class GenerateResult
{
	use ResultTrait;

	private string $pdf;

	public function getPdf(): string
	{
		return $this->pdf;
	}

	public function setPdf(string $pdf): void
	{
		$this->pdf = $pdf;
	}
}