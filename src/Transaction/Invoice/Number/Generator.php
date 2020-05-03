<?php
namespace Ecommerce\Transaction\Invoice\Number;

interface Generator
{
	/**
	 * @param GenerateData $data
	 * @return GenerateResult
	 */
	public function generate(GenerateData $data): GenerateResult;
}