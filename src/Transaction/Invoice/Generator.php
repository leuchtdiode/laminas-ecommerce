<?php
namespace Ecommerce\Transaction\Invoice;

interface Generator
{
	public function generate(GenerateData $data): GenerateResult;
}