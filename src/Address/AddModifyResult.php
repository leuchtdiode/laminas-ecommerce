<?php
namespace Ecommerce\Address;

use Ecommerce\Common\ResultTrait;

class AddModifyResult
{
	use ResultTrait;

	/**
	 * @var Address|null
	 */
	private $address;

	/**
	 * @return Address|null
	 */
	public function getAddress(): ?Address
	{
		return $this->address;
	}

	/**
	 * @param Address|null $address
	 */
	public function setAddress(?Address $address): void
	{
		$this->address = $address;
	}
}