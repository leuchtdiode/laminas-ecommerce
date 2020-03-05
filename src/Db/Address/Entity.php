<?php
namespace Ecommerce\Db\Address;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Ecommerce\Db\Customer\Entity as CustomerEntity;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Table(name="ecommerce_addresses")
 * @ORM\Entity(repositoryClass="Ecommerce\Db\Address\Repository")
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
	 * @ORM\Column(type="string", length=20)
	 */
	private $zip;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255)
	 */
	private $city;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255)
	 */
	private $street;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $extra;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=2)
	 */
	private $country;

	/**
	 * @var bool
	 *
	 * @ORM\Column(type="boolean")
	 */
	private $defaultBilling;

	/**
	 * @var bool
	 *
	 * @ORM\Column(type="boolean")
	 */
	private $defaultShipping;

	/**
	 * @var DateTime
	 *
	 * @ORM\Column(type="datetime");
	 */
	private $createdDate;

	/**
	 * @var CustomerEntity
	 *
	 * @ORM\ManyToOne(targetEntity="Ecommerce\Db\Customer\Entity", inversedBy="addresses")
	 * @ORM\JoinColumn(name="customerId", referencedColumnName="id", nullable=false, onDelete="CASCADE")
	 */
	private $customer;

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
	public function getZip(): string
	{
		return $this->zip;
	}

	/**
	 * @param string $zip
	 */
	public function setZip(string $zip): void
	{
		$this->zip = $zip;
	}

	/**
	 * @return string
	 */
	public function getCity(): string
	{
		return $this->city;
	}

	/**
	 * @param string $city
	 */
	public function setCity(string $city): void
	{
		$this->city = $city;
	}

	/**
	 * @return string
	 */
	public function getStreet(): string
	{
		return $this->street;
	}

	/**
	 * @param string $street
	 */
	public function setStreet(string $street): void
	{
		$this->street = $street;
	}

	/**
	 * @return string|null
	 */
	public function getExtra(): ?string
	{
		return $this->extra;
	}

	/**
	 * @param string|null $extra
	 */
	public function setExtra(?string $extra): void
	{
		$this->extra = $extra;
	}

	/**
	 * @return string
	 */
	public function getCountry(): string
	{
		return $this->country;
	}

	/**
	 * @param string $country
	 */
	public function setCountry(string $country): void
	{
		$this->country = $country;
	}

	/**
	 * @return bool
	 */
	public function isDefaultBilling(): bool
	{
		return $this->defaultBilling;
	}

	/**
	 * @param bool $defaultBilling
	 */
	public function setDefaultBilling(bool $defaultBilling): void
	{
		$this->defaultBilling = $defaultBilling;
	}

	/**
	 * @return bool
	 */
	public function isDefaultShipping(): bool
	{
		return $this->defaultShipping;
	}

	/**
	 * @param bool $defaultShipping
	 */
	public function setDefaultShipping(bool $defaultShipping): void
	{
		$this->defaultShipping = $defaultShipping;
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
}