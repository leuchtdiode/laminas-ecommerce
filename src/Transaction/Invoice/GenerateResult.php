<?php
namespace Ecommerce\Transaction\Invoice;

use Ecommerce\Common\ResultTrait;

class GenerateResult
{
	use ResultTrait;

	/**
	 * @var string
	 */
	private $pdf;

	/**
	 * @return string
	 */
	public function getPdf(): string
	{
		return $this->pdf;
	}

	/**
	 * @param string $pdf
	 */
	public function setPdf(string $pdf): void
	{
		$this->pdf = $pdf;
	}
}