<?php
namespace Ecommerce\Transaction\Invoice;

interface Generator
{
	/**
	 * @param GenerateData $data
	 * @return GenerateResult
	 */
	public function generate(GenerateData $data): GenerateResult;
}