<?php
namespace Ecommerce\Product\Attribute\Value;

use Common\Hydration\ArrayHydratable;
use Ecommerce\Db\Product\Attribute\Value\Entity;
use Ecommerce\Product\Attribute\Attribute;
use Ramsey\Uuid\UuidInterface;

class Value implements ArrayHydratable
{
	/**
	 * @var Entity
	 */
	private $entity;

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var Attribute
	 */
	private $attribute;

	/**
	 * @param Entity $entity
	 * @param Attribute $attribute
	 */
	public function __construct(Entity $entity, Attribute $attribute)
	{
		$this->entity    = $entity;
		$this->attribute = $attribute;
	}

	/**
	 * @return Attribute
	 */
	public function getAttribute(): Attribute
	{
		return $this->attribute;
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
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->entity->getValue();
	}

		/**
	 * @return Entity
	 */
	public function getEntity(): Entity
	{
		return $this->entity;
	}
}