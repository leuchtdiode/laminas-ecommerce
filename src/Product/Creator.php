<?php
namespace Ecommerce\Product;

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
	/**
	 * @var PriceCreator
	 */
	private $priceCreator;

	/**
	 * @var StatusProvider
	 */
	private $statusProvider;

	/**
	 * @var UrlProvider
	 */
	private $urlProvider;

	/**
	 * @var ProductAttributeValueCreator
	 */
	private $productAttributeValueCreator;

	/**
	 * @var ProductImageCreator
	 */
	private $productImageCreator;

	/**
	 * @param PriceCreator $priceCreator
	 * @param StatusProvider $statusProvider
	 * @param UrlProvider $urlProvider
	 */
	public function __construct(PriceCreator $priceCreator, StatusProvider $statusProvider, UrlProvider $urlProvider)
	{
		$this->priceCreator   = $priceCreator;
		$this->statusProvider = $statusProvider;
		$this->urlProvider    = $urlProvider;
	}

	/**
	 * @param ProductAttributeValueCreator $productAttributeValueCreator
	 */
	public function setProductAttributeValueCreator(ProductAttributeValueCreator $productAttributeValueCreator): void
	{
		$this->productAttributeValueCreator = $productAttributeValueCreator;
	}

	/**
	 * @param ProductImageCreator $productImageCreator
	 */
	public function setProductImageCreator(ProductImageCreator $productImageCreator): void
	{
		$this->productImageCreator = $productImageCreator;
	}

	/**
	 * @param Entity $entity
	 * @return Product
	 */
	public function byEntity($entity)
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

	/**
	 * @param Entity $entity
	 * @return Image|null
	 */
	private function getMainImage(Entity $entity)
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