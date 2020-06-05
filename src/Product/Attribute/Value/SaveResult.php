<?php
namespace Ecommerce\Product\Attribute\Value;

use Ecommerce\Common\ResultTrait;

class SaveResult
{
	use ResultTrait;

	/**
	 * @var Value|null
	 */
	private $value;

	/**
	 * @return Value|null
	 */
	public function getValue(): ?Value
	{
		return $this->value;
	}

	/**
	 * @param Value|null $value
	 */
	public function setValue(?Value $value): void
	{
		$this->value = $value;
	}
}