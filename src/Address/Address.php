<?php
namespace Ecommerce\Address;

use Common\Country\Country;
use Common\Hydration\ArrayHydratable;
use Ecommerce\Db\Address\Entity;
use Ramsey\Uuid\UuidInterface;

class Address implements ArrayHydratable
{
	/**
	 * @var Entity
	 */
	private $entity;

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var Country
	 */
	private $country;

	/**
	 * @param Entity $entity
	 * @param Country $country
	 */
	public function __construct(Entity $entity, Country $country)
	{
		$this->entity  = $entity;
		$this->country = $country;
	}

	/**
	 * @return Country
	 */
	public function getCountry()
	{
		return $this->country;
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
	public function getZip()
	{
		return $this->entity->getZip();
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getCity()
	{
		return $this->entity->getCity();
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getStreet()
	{
		return $this->entity->getStreet();
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return null|string
	 */
	public function getExtra()
	{
		return $this->entity->getExtra();
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return bool
	 */
	public function isDefaultBilling()
	{
		return $this->entity->isDefaultBilling();
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return bool
	 */
	public function isDefaultShipping()
	{
		return $this->entity->isDefaultShipping();
	}

	/**
	 * @return Entity
	 */
	public function getEntity(): Entity
	{
		return $this->entity;
	}
}