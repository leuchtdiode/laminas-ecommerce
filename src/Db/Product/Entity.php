<?php
namespace Ecommerce\Db\Product;

use Common\Db\Entity as DbEntity;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Ecommerce\Db\Product\Attribute\Value\Entity as ProductAttributeValueEntity;
use Ecommerce\Db\Product\Image\Entity as ProductImageEntity;
use Ecommerce\Product\Status;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Table(name: 'ecommerce_products')]
#[ORM\UniqueConstraint(columns: [ 'number' ])]
#[ORM\Entity(repositoryClass: Repository::class)]
class Entity implements DbEntity
{
	#[ORM\Id]
	#[ORM\Column(type: 'uuid')]
	private UuidInterface $id;

	#[ORM\Column(type: 'string', length: 100)]
	private string $number;

	#[ORM\Column(type: 'string', length: 255)]
	private string $title;

	#[ORM\Column(type: 'text', nullable: true)]
	private ?string $description = null;

	#[ORM\Column(type: 'string', length: 25)]
	private string $status;

	#[ORM\Column(type: 'integer')]
	private int $stock;

	#[ORM\Column(type: 'integer')]
	private int $price;

	#[ORM\Column(type: 'datetime')]
	private DateTime $createdDate;

	/**
	 * @var Collection|ProductAttributeValueEntity[]
	 */
	#[ORM\ManyToMany(targetEntity: ProductAttributeValueEntity::class)]
	#[ORM\JoinTable(name: 'ecommerce_products__attribute_values')]
	#[ORM\JoinColumn(name: 'productId', onDelete: 'CASCADE')]
	#[ORM\InverseJoinColumn(name: 'productAttributeValueId')]
	private Collection|array $attributeValues;

	/**
	 * @var Collection|ProductImageEntity[]
	 */
	#[OneToMany(
		mappedBy: 'product',
		targetEntity: ProductImageEntity::class,
		cascade: [ 'persist' ],
		orphanRemoval: true
	)]
	private Collection|array $images;

	/**
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->id              = Uuid::uuid4();
		$this->stock           = 0;
		$this->status          = Status::INACTIVE;
		$this->createdDate     = new DateTime();
		$this->attributeValues = new ArrayCollection();
		$this->images          = new ArrayCollection();
	}

	public function getId(): UuidInterface
	{
		return $this->id;
	}

	public function setId(UuidInterface $id): void
	{
		$this->id = $id;
	}

	public function getNumber(): string
	{
		return $this->number;
	}

	public function setNumber(string $number): void
	{
		$this->number = $number;
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function setTitle(string $title): void
	{
		$this->title = $title;
	}

	public function getDescription(): ?string
	{
		return $this->description;
	}

	public function setDescription(?string $description): void
	{
		$this->description = $description;
	}

	public function getStatus(): string
	{
		return $this->status;
	}

	public function setStatus(string $status): void
	{
		$this->status = $status;
	}

	public function getStock(): int
	{
		return $this->stock;
	}

	public function setStock(int $stock): void
	{
		$this->stock = $stock;
	}

	public function getPrice(): int
	{
		return $this->price;
	}

	public function setPrice(int $price): void
	{
		$this->price = $price;
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
	 * @return ProductAttributeValueEntity[]|Collection
	 */
	public function getAttributeValues(): array|Collection
	{
		return $this->attributeValues;
	}

	/**
	 * @param ProductAttributeValueEntity[]|Collection $attributeValues
	 */
	public function setAttributeValues(array|Collection $attributeValues): void
	{
		$this->attributeValues = $attributeValues;
	}

	/**
	 * @return ProductImageEntity[]|Collection
	 */
	public function getImages(): array|Collection
	{
		return $this->images;
	}

	/**
	 * @param ProductImageEntity[]|Collection $images
	 */
	public function setImages(array|Collection $images): void
	{
		$this->images = $images;
	}
}