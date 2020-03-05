<?php
namespace Ecommerce\Product\Attribute\Value;

use Ecommerce\Common\EntityDtoCreator;
use Ecommerce\Db\Product\Attribute\Value\Entity;
use Ecommerce\Product\Attribute\Creator as ProductAttributeCreator;

class Creator implements EntityDtoCreator
{
	/**
	 * @var ProductAttributeCreator
	 */
	private $productAttributeCreator;

	/**
	 * @param ProductAttributeCreator $productAttributeCreator
	 */
	public function setProductAttributeCreator(ProductAttributeCreator $productAttributeCreator): void
	{
		$this->productAttributeCreator = $productAttributeCreator;
	}
	/**
	 * @param Entity $entity
	 * @return Value
	 */
	public function byEntity($entity)
	{
		return new Value(
			$entity,
			$this->productAttributeCreator->byEntity($entity->getAttribute())
		);
	}
}