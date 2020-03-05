<?php
namespace Ecommerce\Product\Attribute;

use Common\Hydration\ArrayHydratable;
use Ecommerce\Db\Product\Attribute\Entity;
use Ramsey\Uuid\UuidInterface;

class Attribute implements ArrayHydratable
{
	/**
	 * @var Entity
	 */
	private $entity;

	/**
	 * @param Entity $entity
	 */
	public function __construct(Entity $entity)
	{
		$this->entity = $entity;
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
	 * @return string
	 */
	public function getProcessableId()
	{
		return $this->entity->getProcessableId();
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getDescription()
	{
		return $this->entity->getDescription();
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string|null
	 */
	public function getUnit()
	{
		return $this->entity->getUnit();
	}

	/**
	 * @return Entity
	 */
	public function getEntity(): Entity
	{
		return $this->entity;
	}
}