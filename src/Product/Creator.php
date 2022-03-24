<?php
namespace Ecommerce\Product;

use Common\Db\Entity as DbEntity;
use Doctrine\Common\Collections\Criteria;
use Ecommerce\Common\EntityDtoCreator;
use Ecommerce\Common\PriceCreator;
use Ecommerce\Db\Product\Attribute\Value\Entity as ProductAttributeValueEntity;
use Ecommerce\Db\Product\Entity;
use Ecommerce\Product\Attribute\Value\Creator as ProductAttributeValueCreator;
use Ecommerce\Product\Image\Creator as ProductImageCreator;
use Ecommerce\Product\Image\Image;

class Creator implements EntityDtoCreator
{
	private PriceCreator $priceCreator;

	private StatusProvider $statusProvider;

	private UrlProvider $urlProvider;

	private ProductAttributeValueCreator $productAttributeValueCreator;

	private ProductImageCreator $productImageCreator;

	public function __construct(PriceCreator $priceCreator, StatusProvider $statusProvider, UrlProvider $urlProvider)
	{
		$this->priceCreator   = $priceCreator;
		$this->statusProvider = $statusProvider;
		$this->urlProvider    = $urlProvider;
	}

	public function setProductAttributeValueCreator(ProductAttributeValueCreator $productAttributeValueCreator): void
	{
		$this->productAttributeValueCreator = $productAttributeValueCreator;
	}

	public function setProductImageCreator(ProductImageCreator $productImageCreator): void
	{
		$this->productImageCreator = $productImageCreator;
	}

	/**
	 * @param Entity $entity
	 */
	public function byEntity(DbEntity $entity): Product
	{
		return new Product(
			$entity,
			$this->statusProvider->byId($entity->getStatus()),
			$this->priceCreator->fromCents($entity->getPrice()),
			array_map(
				function (ProductAttributeValueEntity $entity)
				{
					return $this->productAttributeValueCreator->byEntity($entity);
				},
				$entity->getAttributeValues()->toArray()
			),
			$this->getMainImage($entity),
			$this->urlProvider->get($entity->getId())
		);
	}

	private function getMainImage(Entity $entity): ?Image
	{
		$imageEntities = $entity
			->getImages()
			->matching(
				Criteria::create()
					->where(Criteria::expr()->eq('main', true))
			);

		return $imageEntities->count() === 1
			? $this->productImageCreator->byEntity($imageEntities->first())
			: null;
	}
}