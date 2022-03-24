<?php
namespace Ecommerce\Rest\Action\Customer\Address;

use Common\Hydration\ArrayHydratable;
use Common\Hydration\ObjectToArrayHydratorProperty;
use Ecommerce\Address\Address;

class GetListSuccessData implements ArrayHydratable
{
	/**
	 * @var Address[]
	 */
	#[ObjectToArrayHydratorProperty]
	private array $addresses;

	public static function create(): self
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
	 */
	public function setAddresses(array $addresses): GetListSuccessData
	{
		$this->addresses = $addresses;
		return $this;
	}
}