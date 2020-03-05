<?php
namespace Ecommerce\Db\Transaction;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ecommerce\Db\Address\Entity as AddressEntity;
use Ecommerce\Db\Customer\Entity as CustomerEntity;
use Ecommerce\Db\Transaction\Item\Entity as TransactionItemEntity;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Table(name="ecommerce_transactions")
 * @ORM\Entity(repositoryClass="Ecommerce\Db\Transaction\Repository")
 */
class Entity
{
	/**
	 * @var UuidInterface
	 *
	 * @ORM\Id
	 * @ORM\Column(type="uuid");
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=20, nullable=false)
	 */
	private $referenceNumber;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=50)
	 */
	private $status;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=50)
	 */
	private $paymentMethod;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $foreignId;

	/**
	 * @var DateTime
	 *
	 * @ORM\Column(type="datetime")
	 */
	private $createdDate;

	/**
	 * @var CustomerEntity
	 *
	 * @ORM\ManyToOne(targetEntity="Ecommerce\Db\Customer\Entity")
	 * @ORM\JoinColumn(name="customerId", referencedColumnName="id", nullable=false)
	 */
	private $customer;

	/**
	 * @var ArrayCollection|TransactionItemEntity[]
	 *
	 * @ORM\OneToMany(targetEntity="Ecommerce\Db\Transaction\Item\Entity", mappedBy="transaction", cascade={"persist"})
	 */
	private $items;

	/**
	 * @var AddressEntity
	 *
	 * @ORM\ManyToOne(targetEntity="Ecommerce\Db\Address\Entity")
	 * @ORM\JoinColumn(name="billingAddressId", referencedColumnName="id", nullable=false)
	 */
	private $billingAddress;

	/**
	 * @var AddressEntity
	 *
	 * @ORM\ManyToOne(targetEntity="Ecommerce\Db\Address\Entity")
	 * @ORM\JoinColumn(name="shippingAddressId", referencedColumnName="id", nullable=false)
	 */
	private $shippingAddress;

	/**
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->id          = Uuid::uuid4();
		$this->createdDate = new DateTime();
		$this->items       = new ArrayCollection();
	}

	/**
	 * @return UuidInterface
	 */
	public function getId(): UuidInterface
	{
		return $this->id;
	}

	/**
	 * @param UuidInterface $id
	 */
	public function setId(UuidInterface $id): void
	{
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	public function getReferenceNumber(): string
	{
		return $this->referenceNumber;
	}

	/**
	 * @param string $referenceNumber
	 */
	public function setReferenceNumber(string $referenceNumber): void
	{
		$this->referenceNumber = $referenceNumber;
	}

	/**
	 * @return string
	 */
	public function getStatus(): string
	{
		return $this->status;
	}

	/**
	 * @param string $status
	 */
	public function setStatus(string $status): void
	{
		$this->status = $status;
	}

	/**
	 * @return string
	 */
	public function getPaymentMethod(): string
	{
		return $this->paymentMethod;
	}

	/**
	 * @param string $paymentMethod
	 */
	public function setPaymentMethod(string $paymentMethod): void
	{
		$this->paymentMethod = $paymentMethod;
	}

	/**
	 * @return string|null
	 */
	public function getForeignId(): ?string
	{
		return $this->foreignId;
	}

	/**
	 * @param string|null $foreignId
	 */
	public function setForeignId(?string $foreignId): void
	{
		$this->foreignId = $foreignId;
	}

	/**
	 * @return DateTime
	 */
	public function getCreatedDate(): DateTime
	{
		return $this->createdDate;
	}

	/**
	 * @param DateTime $createdDate
	 */
	public function setCreatedDate(DateTime $createdDate): void
	{
		$this->createdDate = $createdDate;
	}

	/**
	 * @return CustomerEntity
	 */
	public function getCustomer(): CustomerEntity
	{
		return $this->customer;
	}

	/**
	 * @param CustomerEntity $customer
	 */
	public function setCustomer(CustomerEntity $customer): void
	{
		$this->customer = $customer;
	}

	/**
	 * @return ArrayCollection|TransactionItemEntity[]
	 */
	public function getItems()
	{
		return $this->items;
	}

	/**
	 * @param ArrayCollection|TransactionItemEntity[] $items
	 */
	public function setItems($items): void
	{
		$this->items = $items;
	}

	/**
	 * @return AddressEntity
	 */
	public function getBillingAddress(): AddressEntity
	{
		return $this->billingAddress;
	}

	/**
	 * @param AddressEntity $billingAddress
	 */
	public function setBillingAddress(AddressEntity $billingAddress): void
	{
		$this->billingAddress = $billingAddress;
	}

	/**
	 * @return AddressEntity
	 */
	public function getShippingAddress(): AddressEntity
	{
		return $this->shippingAddress;
	}

	/**
	 * @param AddressEntity $shippingAddress
	 */
	public function setShippingAddress(AddressEntity $shippingAddress): void
	{
		$this->shippingAddress = $shippingAddress;
	}
}