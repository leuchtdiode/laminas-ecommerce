<?php
namespace Ecommerce\Address;

use Ecommerce\Common\ResultTrait;

class AddModifyResult
{
	use ResultTrait;

	private ?Address $address = null;

	public function getAddress(): ?Address
	{
		return $this->address;
	}

	public function setAddress(?Address $address): void
	{
		$this->address = $address;
	}
}