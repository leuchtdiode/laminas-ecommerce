<?php
namespace Ecommerce\Product\Attribute;

use Ecommerce\Common\EntityDtoCreator;

class Creator implements EntityDtoCreator
{
	/**
	 * @param $entity
	 * @return Attribute
	 */
	public function byEntity($entity)
	{
		return new Attribute($entity);
	}
}