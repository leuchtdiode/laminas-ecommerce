<?php
namespace Ecommerce\Common;

use Common\Hydration\ObjectToArrayHydratorProperty;

trait IdLabelObject
{
	#[ObjectToArrayHydratorProperty]
	private string $id;

	#[ObjectToArrayHydratorProperty]
	private string $label;

	/**
	 * @param string $id
	 * @param string $label
	 */
	public function __construct(string $id, string $label)
	{
		$this->id    = $id;
		$this->label = $label;
	}

	public function __toString(): string
	{
		return $this->getLabel();
	}

	public function is(string $id): bool
	{
		return $this->id === $id;
	}

	public function getId(): string
	{
		return $this->id;
	}

	public function getLabel(): string
	{
		return $this->label;
	}
}