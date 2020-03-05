<?php
namespace Ecommerce\Product\Image;

use Assets\File\File;
use Common\Hydration\ArrayHydratable;
use Ecommerce\Db\Product\Image\Entity;
use Ramsey\Uuid\UuidInterface;

class Image implements ArrayHydratable
{
	/**
	 * @var Entity
	 */
	private $entity;

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var File
	 */
	private $file;

	/**
	 * @param Entity $entity
	 * @param File $file
	 */
	public function __construct(Entity $entity, File $file)
	{
		$this->entity = $entity;
		$this->file   = $file;
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return UuidInterface
	 */
	public function getId()
	{
		return $this->entity->getId();
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return bool
	 */
	public function isMain()
	{
		return $this->entity->isMain();
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return int
	 */
	public function getSort()
	{
		return $this->entity->getSort();
	}

	/**
	 * @return Entity
	 */
	public function getEntity(): Entity
	{
		return $this->entity;
	}

	/**
	 * @return File
	 */
	public function getFile(): File
	{
		return $this->file;
	}
}