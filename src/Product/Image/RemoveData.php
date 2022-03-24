<?php
namespace Ecommerce\Product\Image;

use Ecommerce\Product\Product;

class RemoveData
{
	private ?Image $image = null;

	private ?Product $product = null;

	public static function create(): self
	{
		return new self();
	}

	public function getImage(): ?Image
	{
		return $this->image;
	}

	public function setImage(?Image $image): RemoveData
	{
		$this->image = $image;
		return $this;
	}

	public function getProduct(): ?Product
	{
		return $this->product;
	}

	public function setProduct(?Product $product): RemoveData
	{
		$this->product = $product;
		return $this;
	}
}