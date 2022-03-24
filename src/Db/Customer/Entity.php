<?php
namespace Ecommerce\Db\Customer;

use Common\Db\Entity as DbEntity;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Ecommerce\Customer\Status;
use Ecommerce\Db\Address\Entity as AddressEntity;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Table(name: 'ecommerce_customers')]
#[ORM\Entity(repositoryClass: Repository::class)]
class Entity implements DbEntity
{
	#[ORM\Id]
	#[ORM\Column(type: 'uuid')]
	private UuidInterface $id;

	#[ORM\Column(type: 'string', length: 50)]
	private string $status;

	#[ORM\Column(type: 'string', length: 255)]
	private string $email;

	#[ORM\Column(type: 'string', length: 255)]
	private string $password;

	#[ORM\Column(type: 'string', length: 10)]
	private string $salutation;

	#[ORM\Column(type: 'string', length: 255, nullable: true)]
	private ?string $title = null;

	#[ORM\Column(type: 'string', length: 255)]
	private string $firstName;

	#[ORM\Column(type: 'string', length: 255)]
	private string $lastName;

	#[ORM\Column(type: 'string', length: 255, nullable: true)]
	private ?string $company = null;

	#[ORM\Column(type: 'string', length: 150, nullable: true)]
	private ?string $taxNumber = null;

	#[ORM\Column(type: 'string', length: 20, nullable: true)]
	private ?string $forgotPasswordHash = null;

	#[ORM\Column(type: 'string', length: 10, nullable: true)]
	private ?string $locale = null;

	#[ORM\Column(type: 'datetime')]
	private DateTime $createdDate;

	#[OneToMany(mappedBy: 'customer', targetEntity: AddressEntity::class)]
	private Collection|array $addresses;

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

	public function getId(): UuidInterface
	{
		return $this->id;
	}

	public function setId(UuidInterface $id): void
	{
		$this->id = $id;
	}

	public function getStatus(): string
	{
		return $this->status;
	}

	public function setStatus(string $status): void
	{
		$this->status = $status;
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function setEmail(string $email): void
	{
		$this->email = $email;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	public function setPassword(string $password): void
	{
		$this->password = $password;
	}

	public function getSalutation(): string
	{
		return $this->salutation;
	}

	public function setSalutation(string $salutation): void
	{
		$this->salutation = $salutation;
	}

	public function getTitle(): ?string
	{
		return $this->title;
	}

	public function setTitle(?string $title): void
	{
		$this->title = $title;
	}

	public function getFirstName(): string
	{
		return $this->firstName;
	}

	public function setFirstName(string $firstName): void
	{
		$this->firstName = $firstName;
	}

	public function getLastName(): string
	{
		return $this->lastName;
	}

	public function setLastName(string $lastName): void
	{
		$this->lastName = $lastName;
	}

	public function getCompany(): ?string
	{
		return $this->company;
	}

	public function setCompany(?string $company): void
	{
		$this->company = $company;
	}

	public function getTaxNumber(): ?string
	{
		return $this->taxNumber;
	}

	public function setTaxNumber(?string $taxNumber): void
	{
		$this->taxNumber = $taxNumber;
	}

	public function getForgotPasswordHash(): ?string
	{
		return $this->forgotPasswordHash;
	}

	public function setForgotPasswordHash(?string $forgotPasswordHash): void
	{
		$this->forgotPasswordHash = $forgotPasswordHash;
	}

	public function getLocale(): ?string
	{
		return $this->locale;
	}

	public function setLocale(?string $locale): void
	{
		$this->locale = $locale;
	}

	public function getCreatedDate(): DateTime
	{
		return $this->createdDate;
	}

	public function setCreatedDate(DateTime $createdDate): void
	{
		$this->createdDate = $createdDate;
	}

	/**
	 * @return Collection|AddressEntity[]
	 */
	public function getAddresses(): Collection|array
	{
		return $this->addresses;
	}

	/**
	 * @param Collection|AddressEntity[] $addresses
	 */
	public function setAddresses(Collection|array $addresses): void
	{
		$this->addresses = $addresses;
	}
}