<?php
namespace Ecommerce\Rest\Action\Customer\Address;

use Common\Hydration\ArrayHydratable;
use Ecommerce\Address\Address;

class AddOrModifySuccessData implements ArrayHydratable
{
	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var Address
	 */
	private $address;

	/**
	 * @return AddOrModifySuccessData
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @return Address
	 */
	public function getAddress(): Address
	{
		return $this->address;
	}

	/**
	 * @param Address $address
	 * @return AddOrModifySuccessData
	 */
	public function setAddress(Address $address): AddOrModifySuccessData
	{
		$this->address = $address;
		return $this;
	}
}