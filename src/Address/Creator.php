<?php
namespace Ecommerce\Address;

use Common\Db\Entity as DbEntity;
use Common\Country\Provider as CountryProvider;
use Ecommerce\Common\EntityDtoCreator;
use Ecommerce\Db\Address\Entity;
use Exception;

class Creator implements EntityDtoCreator
{
	private CountryProvider $countryProvider;

	public function __construct(CountryProvider $countryProvider)
	{
		$this->countryProvider = $countryProvider;
	}

	/**
	 * @param Entity $entity
	 * @throws Exception
	 */
	public function byEntity(DbEntity $entity): Address
	{
		return new Address(
			$entity,
			$this->countryProvider->byIsoCode($entity->getCountry())
		);
	}
}