<?php
namespace Ecommerce\Db\Transaction;

use Common\Db\Entity as DbEntity;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ecommerce\Db\Address\Entity as AddressEntity;
use Ecommerce\Db\Customer\Entity as CustomerEntity;
use Ecommerce\Db\Transaction\Item\Entity as TransactionItemEntity;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Table(name: 'ecommerce_transactions')]
#[ORM\Entity(repositoryClass: Repository::class)]
class Entity implements DbEntity
{
	#[ORM\Id]
	#[ORM\Column(type: 'uuid')]
	private UuidInterface $id;

	#[ORM\Column(type: 'string', length: 20, nullable: false)]
	private string $referenceNumber;

	#[ORM\Column(type: 'string', length: 50, nullable: true)]
	private ?string $invoiceNumber = null;

	#[ORM\Column(type: 'integer', nullable: true)]
	private ?int $consecutiveSuccessNumberInYear = null;

	#[ORM\Column(type: 'string', length: 50)]
	private string $status;

	#[ORM\Column(type: 'string', length: 50, nullable: true)]
	private ?string $postPaymentStatus = null;

	#[ORM\Column(type: 'string', length: 50)]
	private string $paymentMethod;

	#[ORM\Column(type: 'string', nullable: true)]
	private ?string $foreignId = null;

	#[ORM\Column(type: 'integer', nullable: true)]
	private ?int $shippingCost = null;

	#[ORM\Column(type: 'datetime', nullable: true)]
	private DateTime $createdDate;

	#[ORM\ManyToOne(targetEntity: CustomerEntity::class)]
	#[ORM\JoinColumn(name: 'customerId', nullable: false)]
	private CustomerEntity $customer;

	/**
	 * @var Collection|TransactionItemEntity[]
	 */
	#[ORM\OneToMany(mappedBy: 'transaction', targetEntity: TransactionItemEntity::class, cascade: [ 'persist' ])]
	private Collection|array $items;

	#[ORM\ManyToOne(targetEntity: AddressEntity::class)]
	#[ORM\JoinColumn(name: 'billingAddressId', nullable: false)]
	private AddressEntity $billingAddress;

	#[ORM\ManyToOne(targetEntity: AddressEntity::class)]
	#[ORM\JoinColumn(name: 'shippingAddressId', nullable: false)]
	private AddressEntity $shippingAddress;

	/**
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->id          = Uuid::uuid4();
		$this->createdDate = new DateTime();
		$this->items       = new ArrayCollection();
	}

	public function getId(): UuidInterface
	{
		return $this->id;
	}

	public function setId(UuidInterface $id): void
	{
		$this->id = $id;
	}

	public function getReferenceNumber(): string
	{
		return $this->referenceNumber;
	}

	public function setReferenceNumber(string $referenceNumber): void
	{
		$this->referenceNumber = $referenceNumber;
	}

	public function getInvoiceNumber(): ?string
	{
		return $this->invoiceNumber;
	}

	public function setInvoiceNumber(?string $invoiceNumber): void
	{
		$this->invoiceNumber = $invoiceNumber;
	}

	public function getConsecutiveSuccessNumberInYear(): ?int
	{
		return $this->consecutiveSuccessNumberInYear;
	}

	public function setConsecutiveSuccessNumberInYear(?int $consecutiveSuccessNumberInYear): void
	{
		$this->consecutiveSuccessNumberInYear = $consecutiveSuccessNumberInYear;
	}

	public function getStatus(): string
	{
		return $this->status;
	}

	public function setStatus(string $status): void
	{
		$this->status = $status;
	}

	public function getPostPaymentStatus(): ?string
	{
		return $this->postPaymentStatus;
	}

	public function setPostPaymentStatus(?string $postPaymentStatus): void
	{
		$this->postPaymentStatus = $postPaymentStatus;
	}

	public function getPaymentMethod(): string
	{
		return $this->paymentMethod;
	}

	public function setPaymentMethod(string $paymentMethod): void
	{
		$this->paymentMethod = $paymentMethod;
	}

	public function getForeignId(): ?string
	{
		return $this->foreignId;
	}

	public function setForeignId(?string $foreignId): void
	{
		$this->foreignId = $foreignId;
	}

	public function getShippingCost(): ?int
	{
		return $this->shippingCost;
	}

	public function setShippingCost(?int $shippingCost): void
	{
		$this->shippingCost = $shippingCost;
	}

	public function getCreatedDate(): DateTime
	{
		return $this->createdDate;
	}

	public function setCreatedDate(DateTime $createdDate): void
	{
		$this->createdDate = $createdDate;
	}

	public function getCustomer(): CustomerEntity
	{
		return $this->customer;
	}

	public function setCustomer(CustomerEntity $customer): void
	{
		$this->customer = $customer;
	}

	/**
	 * @return Collection|TransactionItemEntity[]
	 */
	public function getItems(): Collection|array
	{
		return $this->items;
	}

	/**
	 * @param Collection|TransactionItemEntity[] $items
	 */
	public function setItems(Collection|array $items): void
	{
		$this->items = $items;
	}

	public function getBillingAddress(): AddressEntity
	{
		return $this->billingAddress;
	}

	public function setBillingAddress(AddressEntity $billingAddress): void
	{
		$this->billingAddress = $billingAddress;
	}

	public function getShippingAddress(): AddressEntity
	{
		return $this->shippingAddress;
	}

	public function setShippingAddress(AddressEntity $shippingAddress): void
	{
		$this->shippingAddress = $shippingAddress;
	}
}