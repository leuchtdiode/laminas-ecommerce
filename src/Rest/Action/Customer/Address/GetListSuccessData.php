<?php
namespace Ecommerce\Rest\Action\Customer\Address;

use Common\Hydration\ArrayHydratable;
use Ecommerce\Address\Address;

class GetListSuccessData implements ArrayHydratable
{
	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var Address[]
	 */
	private $addresses;

	/**
	 * @return GetListSuccessData
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @return Address[]
	 */
	public function getAddresses(): array
	{
		return $this->addresses;
	}

	/**
	 * @param Address[] $addresses
	 * @return GetListSuccessData
	 */
	public function setAddresses(array $addresses): GetListSuccessData
	{
		$this->addresses = $addresses;
		return $this;
	}
}