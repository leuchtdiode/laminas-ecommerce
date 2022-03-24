<?php
namespace Ecommerce\Transaction;

use Common\Dto\Dto;
use Common\Hydration\ArrayHydratable;
use Common\Hydration\ObjectToArrayHydratorProperty;
use DateTime;
use Ecommerce\Address\Address;
use Ecommerce\Common\Price;
use Ecommerce\Customer\Customer;
use Ecommerce\Db\Transaction\Entity;
use Ecommerce\Payment\Method as PaymentMethod;
use Ecommerce\Transaction\Item\Item;
use Ramsey\Uuid\UuidInterface;

class Transaction implements Dto, ArrayHydratable
{
	private Entity $entity;

	#[ObjectToArrayHydratorProperty]
	private Customer $customer;

	#[ObjectToArrayHydratorProperty]
	private Status $status;

	#[ObjectToArrayHydratorProperty]
	private PaymentMethod $paymentMethod;

	/**
	 * @var Item[]
	 */
	#[ObjectToArrayHydratorProperty]
	private array $items;

	#[ObjectToArrayHydratorProperty]
	private Address $billingAddress;

	#[ObjectToArrayHydratorProperty]
	private Address $shippingAddress;

	#[ObjectToArrayHydratorProperty]
	private Price $totalPrice;

	#[ObjectToArrayHydratorProperty]
	private Price $taxAmount;

	#[ObjectToArrayHydratorProperty]
	private ?string $invoiceUrl = null;

	#[ObjectToArrayHydratorProperty]
	private ?Price $shippingCost = null;

	#[ObjectToArrayHydratorProperty]
	private ?PostPaymentStatus $postPaymentStatus = null;

	/**
	 * @param Item[] $items
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
		Price $taxAmount,
		?string $invoiceUrl,
		?Price $shippingCost,
		?PostPaymentStatus $postPaymentStatus
	)
	{
		$this->entity            = $entity;
		$this->customer          = $customer;
		$this->status            = $status;
		$this->paymentMethod     = $paymentMethod;
		$this->items             = $items;
		$this->billingAddress    = $billingAddress;
		$this->shippingAddress   = $shippingAddress;
		$this->totalPrice        = $totalPrice;
		$this->taxAmount         = $taxAmount;
		$this->invoiceUrl        = $invoiceUrl;
		$this->shippingCost      = $shippingCost;
		$this->postPaymentStatus = $postPaymentStatus;
	}

	public function getCustomer(): Customer
	{
		return $this->customer;
	}

	public function getTotalPrice(): Price
	{
		return $this->totalPrice;
	}

	public function getTaxAmount(): Price
	{
		return $this->taxAmount;
	}

	public function getInvoiceUrl(): ?string
	{
		return $this->invoiceUrl;
	}

	public function getShippingCost(): ?Price
	{
		return $this->shippingCost;
	}

	public function getStatus(): Status
	{
		return $this->status;
	}

	public function getPostPaymentStatus(): ?PostPaymentStatus
	{
		return $this->postPaymentStatus;
	}

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

	public function getBillingAddress(): Address
	{
		return $this->billingAddress;
	}

	public function getShippingAddress(): Address
	{
		return $this->shippingAddress;
	}

	#[ObjectToArrayHydratorProperty]
	public function getId(): UuidInterface
	{
		return $this->entity->getId();
	}

	#[ObjectToArrayHydratorProperty]
	public function getReferenceNumber(): string
	{
		return $this->entity->getReferenceNumber();
	}

	#[ObjectToArrayHydratorProperty]
	public function getInvoiceNumber(): ?string
	{
		return $this->entity->getInvoiceNumber();
	}

	#[ObjectToArrayHydratorProperty]
	public function getConsecutiveSuccessNumberInYear(): ?int
	{
		return $this->entity->getConsecutiveSuccessNumberInYear();
	}

	#[ObjectToArrayHydratorProperty]
	public function getCreatedDate(): DateTime
	{
		return $this->entity->getCreatedDate();
	}

	public function getForeignId(): ?string
	{
		return $this->entity->getForeignId();
	}

	public function getEntity(): Entity
	{
		return $this->entity;
	}
}