<?php
namespace Ecommerce\Product\Attribute;

class SaveData
{
	/**
	 * @var Attribute|null
	 */
	private $attribute;

	/**
	 * @var string
	 */
	private $processableId;

	/**
	 * @var string
	 */
	private $description;

	/**
	 * @var string|null
	 */
	private $unit;

	/**
	 * @return SaveData
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @return Attribute|null
	 */
	public function getAttribute(): ?Attribute
	{
		return $this->attribute;
	}

	/**
	 * @param Attribute|null $attribute
	 * @return SaveData
	 */
	public function setAttribute(?Attribute $attribute): SaveData
	{
		$this->attribute = $attribute;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getProcessableId(): string
	{
		return $this->processableId;
	}

	/**
	 * @param string $processableId
	 * @return SaveData
	 */
	public function setProcessableId(string $processableId): SaveData
	{
		$this->processableId = $processableId;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getDescription(): string
	{
		return $this->description;
	}

	/**
	 * @param string $description
	 * @return SaveData
	 */
	public function setDescription(string $description): SaveData
	{
		$this->description = $description;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getUnit(): ?string
	{
		return $this->unit;
	}

	/**
	 * @param string|null $unit
	 * @return SaveData
	 */
	public function setUnit(?string $unit): SaveData
	{
		$this->unit = $unit;
		return $this;
	}
}