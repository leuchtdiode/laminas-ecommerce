<?php
namespace Ecommerce\Product\Attribute;

use Ecommerce\Common\ResultTrait;

class SaveResult
{
	use ResultTrait;

	private ?Attribute $attribute = null;

	public function getAttribute(): ?Attribute
	{
		return $this->attribute;
	}

	public function setAttribute(?Attribute $attribute): void
	{
		$this->attribute = $attribute;
	}
}