<?php
namespace Ecommerce\Product\Attribute\Value;

use Ecommerce\Common\ResultTrait;

class SaveResult
{
	use ResultTrait;

	private ?Value $value = null;

	public function getValue(): ?Value
	{
		return $this->value;
	}

	public function setValue(?Value $value): void
	{
		$this->value = $value;
	}
}