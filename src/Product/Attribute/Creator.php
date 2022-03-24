<?php
namespace Ecommerce\Product\Attribute;

use Common\Db\Entity as DbEntity;
use Ecommerce\Common\EntityDtoCreator;
use Ecommerce\Db\Product\Attribute\Entity;

class Creator implements EntityDtoCreator
{
	/**
	 * @param Entity $entity
	 */
	public function byEntity(DbEntity $entity): Attribute
	{
		return new Attribute($entity);
	}
}