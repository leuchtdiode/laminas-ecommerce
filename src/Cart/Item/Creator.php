<?php
namespace Ecommerce\Cart\Item;

use Common\Db\Entity as DbEntity;
use Ecommerce\Common\EntityDtoCreator;
use Ecommerce\Db\Cart\Item\Entity;
use Ecommerce\Product\Creator as ProductCreator;

class Creator implements EntityDtoCreator
{
	private ProductCreator $productCreator;

	public function setProductCreator(ProductCreator $productCreator): void
	{
		$this->productCreator = $productCreator;
	}

	/**
	 * @param Entity $entity
	 */
	public function byEntity(DbEntity $entity): Item
	{
		return new Item(
			$entity,
			$this->productCreator->byEntity($entity->getProduct())
		);
	}
}