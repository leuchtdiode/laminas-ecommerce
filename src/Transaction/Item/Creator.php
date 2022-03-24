<?php
namespace Ecommerce\Transaction\Item;

use Common\Db\Entity as DbEntity;
use Ecommerce\Common\EntityDtoCreator;
use Ecommerce\Common\PriceCreator;
use Ecommerce\Db\Transaction\Item\Entity;
use Ecommerce\Product\Creator as ProductCreator;

class Creator implements EntityDtoCreator
{
	private PriceCreator $priceCreator;

	private ProductCreator $productCreator;

	public function __construct(PriceCreator $priceCreator)
	{
		$this->priceCreator = $priceCreator;
	}

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
			$this->priceCreator->fromCents($entity->getPrice(), $entity->getTax()),
			$this->productCreator->byEntity($entity->getProduct())
		);
	}
}