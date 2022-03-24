<?php
namespace Ecommerce\Product\Attribute\Value;

use Common\Dto\Dto;
use Common\Hydration\ArrayHydratable;
use Common\Hydration\ObjectToArrayHydratorProperty;
use Ecommerce\Db\Product\Attribute\Value\Entity;
use Ecommerce\Product\Attribute\Attribute;
use Ramsey\Uuid\UuidInterface;

class Value implements Dto, ArrayHydratable
{
	private Entity $entity;

	#[ObjectToArrayHydratorProperty]
	private Attribute $attribute;

	public function __construct(Entity $entity, Attribute $attribute)
	{
		$this->entity    = $entity;
		$this->attribute = $attribute;
	}

	public function getAttribute(): Attribute
	{
		return $this->attribute;
	}

	#[ObjectToArrayHydratorProperty]
	public function getId(): UuidInterface
	{
		return $this->entity->getId();
	}

	#[ObjectToArrayHydratorProperty]
	public function getValue(): string
	{
		return $this->entity->getValue();
	}

	public function getEntity(): Entity
	{
		return $this->entity;
	}
}