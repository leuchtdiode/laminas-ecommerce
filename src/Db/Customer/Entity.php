<?php
namespace Ecommerce\Db\Customer;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ecommerce\Customer\Status;
use Ecommerce\Db\Address\Entity as AddressEntity;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Table(name="ecommerce_customers")
 * @ORM\Entity(repositoryClass="Ecommerce\Db\Customer\Repository")
 */
class Entity
{
	/**
	 * @var UuidInterface
	 *
	 * @ORM\Id
	 * @ORM\Column(type="uuid")
	 */
	private $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=50)
	 */
	private $status;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255)
	 */
	private $email;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255)
	 */
	private $password;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=10)
	 */
	private $salutation;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $title;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255)
	 */
	private $firstName;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255)
	 */
	private $lastName;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $company;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(type="string", length=150, nullable=true)
	 */
	private $taxNumber;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(type="string", length=20, nullable=true)
	 */
	private $forgotPasswordHash;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(type="string", length=10, nullable=true)
	 */
	private $locale;

	/**
	 * @var DateTime
	 *
	 * @ORM\Column(type="datetime")
	 */
	private $createdDate;

	/**
	 * @var ArrayCollection|AddressEntity[]
	 *
	 * @ORM\OneToMany(targetEntity="Ecommerce\Db\Address\Entity", mappedBy="customer")
	 */
	private $addresses;

	/**
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->id          = Uuid::uuid4();
		$this->status      = Status::PENDING_VERIFICATION;
		$this->createdDate = new DateTime();
		$this->addresses   = new ArrayCollection();
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
	public function getEmail(): string
	{
		return $this->email;
	}

	/**
	 * @param string $email
	 */
	public function setEmail(string $email): void
	{
		$this->email = $email;
	}

	/**
	 * @return string
	 */
	public function getPassword(): string
	{
		return $this->password;
	}

	/**
	 * @param string $password
	 */
	public function setPassword(string $password): void
	{
		$this->password = $password;
	}

	/**
	 * @return string
	 */
	public function getSalutation(): string
	{
		return $this->salutation;
	}

	/**
	 * @param string $salutation
	 */
	public function setSalutation(string $salutation): void
	{
		$this->salutation = $salutation;
	}

	/**
	 * @return string|null
	 */
	public function getTitle(): ?string
	{
		return $this->title;
	}

	/**
	 * @param string|null $title
	 */
	public function setTitle(?string $title): void
	{
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getFirstName(): string
	{
		return $this->firstName;
	}

	/**
	 * @param string $firstName
	 */
	public function setFirstName(string $firstName): void
	{
		$this->firstName = $firstName;
	}

	/**
	 * @return string
	 */
	public function getLastName(): string
	{
		return $this->lastName;
	}

	/**
	 * @param string $lastName
	 */
	public function setLastName(string $lastName): void
	{
		$this->lastName = $lastName;
	}

	/**
	 * @return string|null
	 */
	public function getCompany(): ?string
	{
		return $this->company;
	}

	/**
	 * @param string|null $company
	 */
	public function setCompany(?string $company): void
	{
		$this->company = $company;
	}

	/**
	 * @return string|null
	 */
	public function getTaxNumber(): ?string
	{
		return $this->taxNumber;
	}

	/**
	 * @param string|null $taxNumber
	 */
	public function setTaxNumber(?string $taxNumber): void
	{
		$this->taxNumber = $taxNumber;
	}

	/**
	 * @return string|null
	 */
	public function getForgotPasswordHash(): ?string
	{
		return $this->forgotPasswordHash;
	}

	/**
	 * @param string|null $forgotPasswordHash
	 */
	public function setForgotPasswordHash(?string $forgotPasswordHash): void
	{
		$this->forgotPasswordHash = $forgotPasswordHash;
	}

	/**
	 * @return string|null
	 */
	public function getLocale(): ?string
	{
		return $this->locale;
	}

	/**
	 * @param string|null $locale
	 */
	public function setLocale(?string $locale): void
	{
		$this->locale = $locale;
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
	 * @return ArrayCollection|AddressEntity[]
	 */
	public function getAddresses()
	{
		return $this->addresses;
	}

	/**
	 * @param ArrayCollection|AddressEntity[] $addresses
	 */
	public function setAddresses($addresses): void
	{
		$this->addresses = $addresses;
	}
}