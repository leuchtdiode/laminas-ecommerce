<?php
namespace Ecommerce\Product\Attribute;

class SaveData
{
	private ?Attribute $attribute = null;

	private string $processableId;

	private string $description;

	private ?string $unit = null;

	public static function create(): self
	{
		return new self();
	}

	public function getAttribute(): ?Attribute
	{
		return $this->attribute;
	}

	public function setAttribute(?Attribute $attribute): SaveData
	{
		$this->attribute = $attribute;
		return $this;
	}

	public function getProcessableId(): string
	{
		return $this->processableId;
	}

	public function setProcessableId(string $processableId): SaveData
	{
		$this->processableId = $processableId;
		return $this;
	}

	public function getDescription(): string
	{
		return $this->description;
	}

	public function setDescription(string $description): SaveData
	{
		$this->description = $description;
		return $this;
	}

	public function getUnit(): ?string
	{
		return $this->unit;
	}

	public function setUnit(?string $unit): SaveData
	{
		$this->unit = $unit;
		return $this;
	}
}