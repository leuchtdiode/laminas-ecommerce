<?php
namespace Ecommerce\Product;

use Common\Hydration\ArrayHydratable;
use Ecommerce\Common\Equals;
use Ecommerce\Common\Price;
use Ecommerce\Db\Product\Entity;
use Ecommerce\Product\Attribute\Value\Value;
use Ecommerce\Product\Image\Image;
use Ramsey\Uuid\UuidInterface;

class Product implements ArrayHydratable, Equals
{
	/**
	 * @var Entity
	 */
	private $entity;

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var Status
	 */
	private $status;

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var Price
	 */
	private $price;

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var Value[]
	 */
	private $attributeValues;

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var Image|null
	 */
	private $mainImage;

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var string|null
	 */
	private $url;

	/**
	 * @param Entity $entity
	 * @param Status $status
	 * @param Price $price
	 * @param Value[] $attributeValues
	 * @param Image|null $mainImag
	 * @param string|null $url
	 */
	public function __construct(
		Entity $entity,
		Status $status,
		Price $price,
		array $attributeValues,
		?Image $mainImage,
		?string $url
	)
	{
		$this->entity = $entity;
		$this->status = $status;
		$this->price = $price;
		$this->attributeValues = $attributeValues;
		$this->mainImage = $mainImage;
		$this->url = $url;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->getTitle();
	}

	/**
	 * @param Product $toCompare
	 * @return bool
	 */
	public function equals($toCompare)
	{
		return $this->getId()->compareTo($toCompare->getId()) === 0;
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return bool
	 */
	public function isActive()
	{
		return $this->getStatus()->is(Status::ACTIVE);
	}

	/**
	 * @param $quantity
	 * @return bool
	 */
	public function hasEnoughStock($quantity)
	{
		return $this->isInStock() && $quantity <= $this->getStock();
	}

	/**
	 * @return Status
	 */
	public function getStatus(): Status
	{
		return $this->status;
	}

	/**
	 * @return Value[]
	 */
	public function getAttributeValues(): array
	{
		return $this->attributeValues;
	}

	/**
	 * @return Image|null
	 */
	public function getMainImage(): ?Image
	{
		return $this->mainImage;
	}

	/**
	 * @return string|null
	 */
	public function getUrl(): ?string
	{
		return $this->url;
	}

	/**
	 * @return Price
	 */
	public function getPrice(): Price
	{
		return $this->price;
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return bool
	 */
	public function isInStock()
	{
		return $this->getStock() > 0;
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
	public function getNumber()
	{
		return $this->entity->getNumber();
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getTitle()
	{
		return $this->entity->getTitle();
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return null|string
	 */
	public function getDescription()
	{
		return $this->entity->getDescription();
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return integer
	 */
	public function getStock()
	{
		return $this->entity->getStock();
	}

	/**
	 * @return Entity
	 */
	public function getEntity(): Entity
	{
		return $this->entity;
	}
}