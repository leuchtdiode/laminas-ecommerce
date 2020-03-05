<?php
namespace Ecommerce\Transaction\Item;

use Ecommerce\Common\EntityDtoCreator;
use Ecommerce\Common\PriceCreator;
use Ecommerce\Db\Transaction\Item\Entity;
use Ecommerce\Product\Creator as ProductCreator;

class Creator implements EntityDtoCreator
{
	/**
	 * @var PriceCreator
	 */
	private $priceCreator;

	/**
	 * @var ProductCreator
	 */
	private $productCreator;

	/**
	 * @param PriceCreator $priceCreator
	 */
	public function __construct(PriceCreator $priceCreator)
	{
		$this->priceCreator = $priceCreator;
	}

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
			$this->priceCreator->fromCents($entity->getPrice(), $entity->getTax()),
			$this->productCreator->byEntity($entity->getProduct())
		);
	}
}