<?php
namespace Ecommerce\Product\Attribute\Value;

use Common\Db\Entity as DbEntity;
use Ecommerce\Common\EntityDtoCreator;
use Ecommerce\Db\Product\Attribute\Value\Entity;
use Ecommerce\Product\Attribute\Creator as ProductAttributeCreator;

class Creator implements EntityDtoCreator
{
	private ProductAttributeCreator $productAttributeCreator;

	public function setProductAttributeCreator(ProductAttributeCreator $productAttributeCreator): void
	{
		$this->productAttributeCreator = $productAttributeCreator;
	}
	/**
	 * @param Entity $entity
	 */
	public function byEntity(DbEntity $entity): Value
	{
		return new Value(
			$entity,
			$this->productAttributeCreator->byEntity($entity->getAttribute())
		);
	}
}