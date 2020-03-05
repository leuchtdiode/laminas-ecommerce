<?php
namespace Ecommerce\Cart\Item;

use Common\Error;
use Common\Hydration\ArrayHydratable;
use Ecommerce\Db\Cart\Item\Entity;
use Ecommerce\Product\Product;
use Ramsey\Uuid\UuidInterface;

class Item implements ArrayHydratable
{
	/**
	 * @var Entity
	 */
	private $entity;

	/**
	 * @var Product
	 */
	private $product;

	/**
	 * @var Error[]
	 */
	private $validationErrors = [];

	/**
	 * @param Entity $entity
	 * @param Product $product
	 */
	public function __construct(Entity $entity, Product $product)
	{
		$this->entity  = $entity;
		$this->product = $product;
	}

	/**
	 * @param Error $error
	 */
	public function addValidationError(Error $error)
	{
		$this->validationErrors[] = $error;
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return bool
	 */
	public function isValid()
	{
		return empty($this->validationErrors);
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return Product
	 */
	public function getProduct(): Product
	{
		return $this->product;
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
	 * @return Error[]
	 */
	public function getValidationErrors(): array
	{
		return $this->validationErrors;
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return int
	 */
	public function getQuantity()
	{
		return $this->entity->getQuantity();
	}

	/**
	 * @return Entity
	 */
	public function getEntity(): Entity
	{
		return $this->entity;
	}
}