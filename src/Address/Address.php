<?php
namespace Ecommerce\Address;

use Common\Country\Country;
use Common\Dto\Dto;
use Common\Hydration\ArrayHydratable;
use Common\Hydration\ObjectToArrayHydratorProperty;
use Ecommerce\Db\Address\Entity;
use Ramsey\Uuid\UuidInterface;

class Address implements Dto, ArrayHydratable
{
	private Entity $entity;

	#[ObjectToArrayHydratorProperty]
	private Country $country;

	public function __construct(Entity $entity, Country $country)
	{
		$this->entity  = $entity;
		$this->country = $country;
	}

	public function getCountry(): Country
	{
		return $this->country;
	}

	#[ObjectToArrayHydratorProperty]
	public function getId(): UuidInterface
	{
		return $this->entity->getId();
	}

	#[ObjectToArrayHydratorProperty]
	public function getZip(): string
	{
		return $this->entity->getZip();
	}

	#[ObjectToArrayHydratorProperty]
	public function getCity(): string
	{
		return $this->entity->getCity();
	}

	#[ObjectToArrayHydratorProperty]
	public function getStreet(): string
	{
		return $this->entity->getStreet();
	}

	#[ObjectToArrayHydratorProperty]
	public function getExtra(): ?string
	{
		return $this->entity->getExtra();
	}

	#[ObjectToArrayHydratorProperty]
	public function isDefaultBilling(): bool
	{
		return $this->entity->isDefaultBilling();
	}

	#[ObjectToArrayHydratorProperty]
	public function isDefaultShipping(): bool
	{
		return $this->entity->isDefaultShipping();
	}

	public function getEntity(): Entity
	{
		return $this->entity;
	}
}