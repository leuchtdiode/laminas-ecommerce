<?php
namespace Ecommerce\Product\Attribute;

use Common\Dto\Dto;
use Common\Hydration\ArrayHydratable;
use Common\Hydration\ObjectToArrayHydratorProperty;
use Ecommerce\Db\Product\Attribute\Entity;
use Ramsey\Uuid\UuidInterface;

class Attribute implements Dto, ArrayHydratable
{
	private Entity $entity;

	public function __construct(Entity $entity)
	{
		$this->entity = $entity;
	}

	#[ObjectToArrayHydratorProperty]
	public function getId(): UuidInterface
	{
		return $this->entity->getId();
	}

	#[ObjectToArrayHydratorProperty]
	public function getProcessableId(): string
	{
		return $this->entity->getProcessableId();
	}

	#[ObjectToArrayHydratorProperty]
	public function getDescription(): string
	{
		return $this->entity->getDescription();
	}

	#[ObjectToArrayHydratorProperty]
	public function getUnit(): ?string
	{
		return $this->entity->getUnit();
	}

	public function getEntity(): Entity
	{
		return $this->entity;
	}
}