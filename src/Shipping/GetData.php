<?php
namespace Ecommerce\Shipping;

use Ecommerce\Address\Address;
use Ecommerce\Cart\Cart;
use Ecommerce\Customer\Customer;

class GetData
{
	private Cart $cart;
	
	private Customer $customer;

	private Address $shippingAddress;

	public static function create(): self
	{
		return new self();
	}

	public function getCart(): Cart
	{
		return $this->cart;
	}

	public function setCart(Cart $cart): GetData
	{
		$this->cart = $cart;
		return $this;
	}

	public function getCustomer(): Customer
	{
		return $this->customer;
	}

	public function setCustomer(Customer $customer): GetData
	{
		$this->customer = $customer;
		return $this;
	}

	public function getShippingAddress(): Address
	{
		return $this->shippingAddress;
	}

	public function setShippingAddress(Address $shippingAddress): GetData
	{
		$this->shippingAddress = $shippingAddress;
		return $this;
	}
}