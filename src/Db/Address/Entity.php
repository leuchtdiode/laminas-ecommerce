<?php
namespace Ecommerce\Db\Address;

use Common\Db\Entity as DbEntity;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Ecommerce\Db\Customer\Entity as CustomerEntity;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Table(name: 'ecommerce_addresses')]
#[ORM\Entity(repositoryClass: Repository::class)]
class Entity implements DbEntity
{
	#[ORM\Id]
	#[ORM\Column(type: 'uuid')]
	private UuidInterface $id;

	#[ORM\Column(type: 'string', length: 20)]
	private string $zip;

	#[ORM\Column(type: 'string', length: 255)]
	private string $city;

	#[ORM\Column(type: 'string', length: 255)]
	private string $street;

	#[ORM\Column(type: 'string', length: 255, nullable: true)]
	private ?string $extra = null;

	#[ORM\Column(type: 'string', length: 2)]
	private string $country;

	#[ORM\Column(type: 'boolean')]
	private bool $defaultBilling;

	#[ORM\Column(type: 'boolean')]
	private bool $defaultShipping;

	#[ORM\Column(type: 'datetime')]
	private DateTime $createdDate;

	#[ORM\ManyToOne(targetEntity: CustomerEntity::class, inversedBy: 'addresses')]
	#[ORM\JoinColumn(name: 'customerId', nullable: false, onDelete: 'CASCADE')]
	private CustomerEntity $customer;

	/**
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->id              = Uuid::uuid4();
		$this->defaultBilling  = false;
		$this->defaultShipping = false;
		$this->createdDate     = new DateTime();
	}

	public function getId(): UuidInterface
	{
		return $this->id;
	}

	public function setId(UuidInterface $id): void
	{
		$this->id = $id;
	}

	public function getZip(): string
	{
		return $this->zip;
	}

	public function setZip(string $zip): void
	{
		$this->zip = $zip;
	}

	public function getCity(): string
	{
		return $this->city;
	}

	public function setCity(string $city): void
	{
		$this->city = $city;
	}

	public function getStreet(): string
	{
		return $this->street;
	}

	public function setStreet(string $street): void
	{
		$this->street = $street;
	}

	public function getExtra(): ?string
	{
		return $this->extra;
	}

	public function setExtra(?string $extra): void
	{
		$this->extra = $extra;
	}

	public function getCountry(): string
	{
		return $this->country;
	}

	public function setCountry(string $country): void
	{
		$this->country = $country;
	}

	public function isDefaultBilling(): bool
	{
		return $this->defaultBilling;
	}

	public function setDefaultBilling(bool $defaultBilling): void
	{
		$this->defaultBilling = $defaultBilling;
	}

	public function isDefaultShipping(): bool
	{
		return $this->defaultShipping;
	}

	public function setDefaultShipping(bool $defaultShipping): void
	{
		$this->defaultShipping = $defaultShipping;
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
}