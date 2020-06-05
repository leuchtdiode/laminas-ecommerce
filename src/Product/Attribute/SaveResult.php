<?php
namespace Ecommerce\Product\Attribute;

use Ecommerce\Common\ResultTrait;

class SaveResult
{
	use ResultTrait;

	/**
	 * @var Attribute|null
	 */
	private $attribute;

	/**
	 * @return Attribute|null
	 */
	public function getAttribute(): ?Attribute
	{
		return $this->attribute;
	}

	/**
	 * @param Attribute|null $attribute
	 */
	public function setAttribute(?Attribute $attribute): void
	{
		$this->attribute = $attribute;
	}
}