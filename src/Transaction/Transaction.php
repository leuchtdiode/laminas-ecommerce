<?php
namespace Ecommerce\Transaction;

use Common\Hydration\ArrayHydratable;
use DateTime;
use Ecommerce\Address\Address;
use Ecommerce\Common\Price;
use Ecommerce\Customer\Customer;
use Ecommerce\Db\Transaction\Entity;
use Ecommerce\Payment\Method as PaymentMethod;
use Ecommerce\Transaction\Item\Item;
use Ramsey\Uuid\UuidInterface;

class Transaction implements ArrayHydratable
{
	/**
	 * @var Entity
	 */
	private $entity;

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var Customer
	 */
	private $customer;

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var Status
	 */
	private $status;

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var PaymentMethod
	 */
	private $paymentMethod;

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var Item[]
	 */
	private $items;

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var Address
	 */
	private $billingAddress;

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var Address
	 */
	private $shippingAddress;

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var Price
	 */
	private $totalPrice;

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var string|null
	 */
	private $invoiceUrl;

	/**
	 * @param Entity $entity
	 * @param Customer $customer
	 * @param Status $status
	 * @param PaymentMethod $paymentMethod
	 * @param Item[] $items
	 * @param Address $billingAddress
	 * @param Address $shippingAddress
	 * @param Price $totalPrice
	 * @param string|null $invoiceUrl
	 */
	public function __construct(
		Entity $entity,
		Customer $customer,
		Status $status,
		PaymentMethod $paymentMethod,
		array $items,
		Address $billingAddress,
		Address $shippingAddress,
		Price $totalPrice,
		?string $invoiceUrl
	)
	{
		$this->entity          = $entity;
		$this->customer        = $customer;
		$this->status          = $status;
		$this->paymentMethod   = $paymentMethod;
		$this->items           = $items;
		$this->billingAddress  = $billingAddress;
		$this->shippingAddress = $shippingAddress;
		$this->totalPrice      = $totalPrice;
		$this->invoiceUrl      = $invoiceUrl;
	}

	/**
	 * @return Customer
	 */
	public function getCustomer(): Customer
	{
		return $this->customer;
	}

	/**
	 * @return Price
	 */
	public function getTotalPrice(): Price
	{
		return $this->totalPrice;
	}

	/**
	 * @return string|null
	 */
	public function getInvoiceUrl(): ?string
	{
		return $this->invoiceUrl;
	}

	/**
	 * @return Status
	 */
	public function getStatus(): Status
	{
		return $this->status;
	}

	/**
	 * @return PaymentMethod
	 */
	public function getPaymentMethod(): PaymentMethod
	{
		return $this->paymentMethod;
	}

	/**
	 * @return Item[]
	 */
	public function getItems(): array
	{
		return $this->items;
	}

	/**
	 * @return Address
	 */
	public function getBillingAddress(): Address
	{
		return $this->billingAddress;
	}

	/**
	 * @return Address
	 */
	public function getShippingAddress(): Address
	{
		return $this->shippingAddress;
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return UuidInterface
	 */
	public function getId()
	{
		return $this->entity->getId();
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return string
	 */
	public function getReferenceNumber()
	{
		return $this->entity->getReferenceNumber();
	}

	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @return DateTime
	 */
	public function getCreatedDate()
	{
		return $this->entity->getCreatedDate();
	}

	/**
	 * @return string|null
	 */
	public function getForeignId()
	{
		return $this->entity->getForeignId();
	}

	/**
	 * @return Entity
	 */
	public function getEntity(): Entity
	{
		return $this->entity;
	}
}