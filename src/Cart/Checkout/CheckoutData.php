<?php
namespace Ecommerce\Cart\Checkout;

use DateTime;
use Ecommerce\Address\Address;
use Ecommerce\Cart\Cart;
use Ecommerce\Customer\Customer;
use Ecommerce\Payment\Method;

class CheckoutData
{
	private Customer $customer;

	private Cart $cart;

	private Method $paymentMethod;

	private Address $billingAddress;

	private Address $shippingAddress;

	private ?DateTime $transactionCreatedDate = null;

	public static function create(): self
	{
		return new self();
	}

	public function getCustomer(): Customer
	{
		return $this->customer;
	}

	public function setCustomer(Customer $customer): CheckoutData
	{
		$this->customer = $customer;
		return $this;
	}

	public function getCart(): Cart
	{
		return $this->cart;
	}

	public function setCart(Cart $cart): CheckoutData
	{
		$this->cart = $cart;
		return $this;
	}

	public function getPaymentMethod(): Method
	{
		return $this->paymentMethod;
	}

	public function setPaymentMethod(Method $paymentMethod): CheckoutData
	{
		$this->paymentMethod = $paymentMethod;
		return $this;
	}

	public function getBillingAddress(): Address
	{
		return $this->billingAddress;
	}

	public function setBillingAddress(Address $billingAddress): CheckoutData
	{
		$this->billingAddress = $billingAddress;
		return $this;
	}

	public function getShippingAddress(): Address
	{
		return $this->shippingAddress;
	}

	public function setShippingAddress(Address $shippingAddress): CheckoutData
	{
		$this->shippingAddress = $shippingAddress;
		return $this;
	}

	public function getTransactionCreatedDate(): ?DateTime
	{
		return $this->transactionCreatedDate;
	}

	public function setTransactionCreatedDate(?DateTime $transactionCreatedDate): CheckoutData
	{
		$this->transactionCreatedDate = $transactionCreatedDate;
		return $this;
	}
}