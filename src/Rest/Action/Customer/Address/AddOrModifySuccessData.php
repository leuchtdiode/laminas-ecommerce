<?php
namespace Ecommerce\Rest\Action\Customer\Address;

use Common\Hydration\ArrayHydratable;
use Common\Hydration\ObjectToArrayHydratorProperty;
use Ecommerce\Address\Address;

class AddOrModifySuccessData implements ArrayHydratable
{
	#[ObjectToArrayHydratorProperty]
	private Address $address;

	public static function create(): self
	{
		return new self();
	}

	public function getAddress(): Address
	{
		return $this->address;
	}

	public function setAddress(Address $address): AddOrModifySuccessData
	{
		$this->address = $address;
		return $this;
	}
}