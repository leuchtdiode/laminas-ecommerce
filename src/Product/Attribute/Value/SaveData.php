<?php
namespace Ecommerce\Product\Attribute\Value;

use Ecommerce\Product\Attribute\Attribute;

class SaveData
{
	/**
	 * @var Value|null
	 */
	private $attributeValue;

	/**
	 * @var string
	 */
	private $value;

	/**
	 * @var Attribute
	 */
	private $attribute;

	/**
	 * @return SaveData
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @return Value|null
	 */
	public function getAttributeValue(): ?Value
	{
		return $this->attributeValue;
	}

	/**
	 * @param Value|null $attributeValue
	 * @return SaveData
	 */
	public function setAttributeValue(?Value $attributeValue): SaveData
	{
		$this->attributeValue = $attributeValue;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getValue(): string
	{
		return $this->value;
	}

	/**
	 * @param string $value
	 * @return SaveData
	 */
	public function setValue(string $value): SaveData
	{
		$this->value = $value;
		return $this;
	}

	/**
	 * @return Attribute
	 */
	public function getAttribute(): Attribute
	{
		return $this->attribute;
	}

	/**
	 * @param Attribute $attribute
	 * @return SaveData
	 */
	public function setAttribute(Attribute $attribute): SaveData
	{
		$this->attribute = $attribute;
		return $this;
	}
}