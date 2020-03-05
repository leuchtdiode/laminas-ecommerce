<?php
namespace Ecommerce\Address;

use Common\Country\Provider as CountryProvider;
use Ecommerce\Common\EntityDtoCreator;
use Ecommerce\Db\Address\Entity;
use Exception;

class Creator implements EntityDtoCreator
{
	/**
	 * @var CountryProvider
	 */
	private $countryProvider;

	/**
	 * @param CountryProvider $countryProvider
	 */
	public function __construct(CountryProvider $countryProvider)
	{
		$this->countryProvider = $countryProvider;
	}

	/**
	 * @param Entity $entity
	 * @return Address
	 * @throws Exception
	 */
	public function byEntity($entity)
	{
		return new Address(
			$entity,
			$this->countryProvider->byIsoCode($entity->getCountry())
		);
	}
}