<?php
namespace Ecommerce\Product\Image;

use Ecommerce\Product\Product;

class RemoveData
{
	/**
	 * @var Image|null
	 */
	private $image;

	/**
	 * @var Product|null
	 */
	private $product;

	/**
	 * @return RemoveData
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @return Image|null
	 */
	public function getImage(): ?Image
	{
		return $this->image;
	}

	/**
	 * @param Image|null $image
	 * @return RemoveData
	 */
	public function setImage(?Image $image): RemoveData
	{
		$this->image = $image;
		return $this;
	}

	/**
	 * @return Product|null
	 */
	public function getProduct(): ?Product
	{
		return $this->product;
	}

	/**
	 * @param Product|null $product
	 * @return RemoveData
	 */
	public function setProduct(?Product $product): RemoveData
	{
		$this->product = $product;
		return $this;
	}
}