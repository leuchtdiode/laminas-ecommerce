<?php
namespace Ecommerce\Cart\Item;

use Ecommerce\Common\EntityDtoCreator;
use Ecommerce\Db\Cart\Item\Entity;
use Ecommerce\Product\Creator as ProductCreator;

class Creator implements EntityDtoCreator
{
	/**
	 * @var ProductCreator
	 */
	private $productCreator;

	/**
	 * @param ProductCreator $productCreator
	 */
	public function setProductCreator(ProductCreator $productCreator): void
	{
		$this->productCreator = $productCreator;
	}
	/**
	 * @param Entity $entity
	 * @return Item
	 */
	public function byEntity($entity)
	{
		return new Item(
			$entity,
			$this->productCreator->byEntity($entity->getProduct())
		);
	}
}