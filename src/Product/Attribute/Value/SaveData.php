<?php
namespace Ecommerce\Product\Attribute\Value;

use Ecommerce\Product\Attribute\Attribute;

class SaveData
{
	private ?Value $attributeValue = null;

	private string $value;

	private Attribute $attribute;

	public static function create(): self
	{
		return new self();
	}

	public function getAttributeValue(): ?Value
	{
		return $this->attributeValue;
	}

	public function setAttributeValue(?Value $attributeValue): SaveData
	{
		$this->attributeValue = $attributeValue;
		return $this;
	}

	public function getValue(): string
	{
		return $this->value;
	}

	public function setValue(string $value): SaveData
	{
		$this->value = $value;
		return $this;
	}

	public function getAttribute(): Attribute
	{
		return $this->attribute;
	}

	public function setAttribute(Attribute $attribute): SaveData
	{
		$this->attribute = $attribute;
		return $this;
	}
}