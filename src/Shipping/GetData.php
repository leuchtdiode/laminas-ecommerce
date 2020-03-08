<?php
namespace Ecommerce\Shipping;

use Ecommerce\Address\Address;
use Ecommerce\Cart\Cart;
use Ecommerce\Customer\Customer;

class GetData
{
	/**
	 * @var Cart
	 */
	private $cart;
	
	/**
	 * @var Customer
	 */
	private $customer;

	/**
	 * @var Address
	 */
	private $shippingAddress;

	/**
	 * @return GetData
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @return Cart
	 */
	public function getCart(): Cart
	{
		return $this->cart;
	}

	/**
	 * @param Cart $cart
	 * @return GetData
	 */
	public function setCart(Cart $cart): GetData
	{
		$this->cart = $cart;
		return $this;
	}

	/**
	 * @return Customer
	 */
	public function getCustomer(): Customer
	{
		return $this->customer;
	}

	/**
	 * @param Customer $customer
	 * @return GetData
	 */
	public function setCustomer(Customer $customer): GetData
	{
		$this->customer = $customer;
		return $this;
	}

	/**
	 * @return Address
	 */
	public function getShippingAddress(): Address
	{
		return $this->shippingAddress;
	}

	/**
	 * @param Address $shippingAddress
	 * @return GetData
	 */
	public function setShippingAddress(Address $shippingAddress): GetData
	{
		$this->shippingAddress = $shippingAddress;
		return $this;
	}
}