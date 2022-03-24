<?php
namespace Ecommerce\Product;

use Common\Dto\Dto;
use Common\Hydration\ArrayHydratable;
use Common\Hydration\ObjectToArrayHydratorProperty;
use Ecommerce\Common\Equals;
use Ecommerce\Common\Price;
use Ecommerce\Db\Product\Entity;
use Ecommerce\Product\Attribute\Value\Value;
use Ecommerce\Product\Image\Image;
use Ramsey\Uuid\UuidInterface;

class Product implements Dto, ArrayHydratable, Equals
{
	private Entity $entity;

	#[ObjectToArrayHydratorProperty]
	private Status $status;

	#[ObjectToArrayHydratorProperty]
	private Price $price;

	/**
	 * @var Value[]
	 */
	#[ObjectToArrayHydratorProperty]
	private array $attributeValues;

	#[ObjectToArrayHydratorProperty]
	private ?Image $mainImage = null;

	#[ObjectToArrayHydratorProperty]
	private ?string $url = null;

	/**
	 * @param Value[] $attributeValues
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

	public function __toString(): string
	{
		return $this->getTitle();
	}

	/**
	 * @param Product $toCompare
	 */
	public function equals($toCompare): bool
	{
		return $this->getId()->compareTo($toCompare->getId()) === 0;
	}

	#[ObjectToArrayHydratorProperty]
	public function isActive(): bool
	{
		return $this->getStatus()->is(Status::ACTIVE);
	}

	public function hasEnoughStock(int $quantity): bool
	{
		return $this->isInStock() && $quantity <= $this->getStock();
	}

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

	public function getMainImage(): ?Image
	{
		return $this->mainImage;
	}

	public function getUrl(): ?string
	{
		return $this->url;
	}

	public function getPrice(): Price
	{
		return $this->price;
	}

	#[ObjectToArrayHydratorProperty]
	public function isInStock(): bool
	{
		return $this->getStock() > 0;
	}

	#[ObjectToArrayHydratorProperty]
	public function getId(): UuidInterface
	{
		return $this->entity->getId();
	}

	#[ObjectToArrayHydratorProperty]
	public function getNumber(): string
	{
		return $this->entity->getNumber();
	}

	#[ObjectToArrayHydratorProperty]
	public function getTitle(): string
	{
		return $this->entity->getTitle();
	}

	#[ObjectToArrayHydratorProperty]
	public function getDescription(): ?string
	{
		return $this->entity->getDescription();
	}

	#[ObjectToArrayHydratorProperty]
	public function getStock(): int
	{
		return $this->entity->getStock();
	}

	public function getEntity(): Entity
	{
		return $this->entity;
	}
}