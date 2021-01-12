<?php
namespace Ecommerce\Cart\Checkout;

use DateTime;
use Ecommerce\Address\Address;
use Ecommerce\Cart\Cart;
use Ecommerce\Customer\Customer;
use Ecommerce\Payment\Method;

class CheckoutData
{
	/**
	 * @var Customer
	 */
	private $customer;

	/**
	 * @var Cart
	 */
	private $cart;

	/**
	 * @var Method
	 */
	private $paymentMethod;

	/**
	 * @var Address
	 */
	private $billingAddress;

	/**
	 * @var Address
	 */
	private $shippingAddress;

	/**
	 * @var DateTime|null
	 */
	private $transactionCreatedDate;

	/**
	 * @return CheckoutData
	 */
	public static function create()
	{
		return new self();
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
	 * @return CheckoutData
	 */
	public function setCustomer(Customer $customer): CheckoutData
	{
		$this->customer = $customer;
		return $this;
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
	 * @return CheckoutData
	 */
	public function setCart(Cart $cart): CheckoutData
	{
		$this->cart = $cart;
		return $this;
	}

	/**
	 * @return Method
	 */
	public function getPaymentMethod(): Method
	{
		return $this->paymentMethod;
	}

	/**
	 * @param Method $paymentMethod
	 * @return CheckoutData
	 */
	public function setPaymentMethod(Method $paymentMethod): CheckoutData
	{
		$this->paymentMethod = $paymentMethod;
		return $this;
	}

	/**
	 * @return Address
	 */
	public function getBillingAddress(): Address
	{
		return $this->billingAddress;
	}

	/**
	 * @param Address $billingAddress
	 * @return CheckoutData
	 */
	public function setBillingAddress(Address $billingAddress): CheckoutData
	{
		$this->billingAddress = $billingAddress;
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
	 * @return CheckoutData
	 */
	public function setShippingAddress(Address $shippingAddress): CheckoutData
	{
		$this->shippingAddress = $shippingAddress;
		return $this;
	}

	/**
	 * @return DateTime|null
	 */
	public function getTransactionCreatedDate(): ?DateTime
	{
		return $this->transactionCreatedDate;
	}

	/**
	 * @param DateTime|null $transactionCreatedDate
	 * @return CheckoutData
	 */
	public function setTransactionCreatedDate(?DateTime $transactionCreatedDate): CheckoutData
	{
		$this->transactionCreatedDate = $transactionCreatedDate;
		return $this;
	}
}