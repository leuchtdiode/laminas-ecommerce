<?php
namespace Ecommerce\Product\Image;

use Assets\File\File;
use Common\Dto\Dto;
use Common\Hydration\ArrayHydratable;
use Common\Hydration\ObjectToArrayHydratorProperty;
use Ecommerce\Db\Product\Image\Entity;
use Ramsey\Uuid\UuidInterface;

class Image implements Dto, ArrayHydratable
{
	private Entity $entity;

	#[ObjectToArrayHydratorProperty]
	private File $file;

	public function __construct(Entity $entity, File $file)
	{
		$this->entity = $entity;
		$this->file   = $file;
	}

	#[ObjectToArrayHydratorProperty]
	public function getId(): UuidInterface
	{
		return $this->entity->getId();
	}

	#[ObjectToArrayHydratorProperty]
	public function isMain(): bool
	{
		return $this->entity->isMain();
	}

	#[ObjectToArrayHydratorProperty]
	public function getSort(): int
	{
		return $this->entity->getSort();
	}

	public function getEntity(): Entity
	{
		return $this->entity;
	}

	public function getFile(): File
	{
		return $this->file;
	}
}