<?php
namespace Ecommerce\Transaction\Invoice\Number;

interface Generator
{
	public function generate(GenerateData $data): GenerateResult;
}