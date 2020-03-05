<?php
namespace Ecommerce\Db\Product;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ecommerce\Db\Product\Attribute\Value\Entity as ProductAttributeValueEntity;
use Ecommerce\Db\Product\Image\Entity as ProductImageEntity;
use Ecommerce\Product\Status;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Table(
 *        name="ecommerce_products",
 *        uniqueConstraints={@ORM\UniqueConstraint(columns={"number"})}
 * )
 * @ORM\Entity(repositoryClass="Ecommerce\Db\Product\Repository")
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
	 * @ORM\Column(type="string", length=100)
	 */
	private $number;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=255)
	 */
	private $title;

	/**
	 * @var string|null
	 *
	 * @ORM\Column(type="text")
	 */
	private $description;

	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", length=25)
	 */
	private $status;

	/**
	 * @var int
	 *
	 * @ORM\Column(type="integer")
	 */
	private $stock;

	/**
	 * @var int
	 *
	 * @ORM\Column(type="integer")
	 */
	private $price;

	/**
	 * @var DateTime
	 *
	 * @ORM\Column(type="datetime")
	 */
	private $createdDate;

	/**
	 * @var ArrayCollection|ProductAttributeValueEntity[]
	 *
	 * @ORM\ManyToMany(targetEntity="Ecommerce\Db\Product\Attribute\Value\Entity")
	 * @ORM\JoinTable(name="ecommerce_products__attribute_values",
	 *      joinColumns={@ORM\JoinColumn(name="productId", referencedColumnName="id")},
	 *      inverseJoinColumns={@ORM\JoinColumn(name="productAttributeValueId", referencedColumnName="id")}
	 *      )
	 */
	private $attributeValues;

	/**
	 * @var ArrayCollection|ProductImageEntity[]
	 *
	 * @ORM\OneToMany(targetEntity="Ecommerce\Db\Product\Image\Entity", mappedBy="product", cascade={"persist"}, orphanRemoval=true)
	 */
	private $images;

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
	public function getNumber(): string
	{
		return $this->number;
	}

	/**
	 * @param string $number
	 */
	public function setNumber(string $number): void
	{
		$this->number = $number;
	}

	/**
	 * @return string
	 */
	public function getTitle(): string
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle(string $title): void
	{
		$this->title = $title;
	}

	/**
	 * @return string|null
	 */
	public function getDescription(): ?string
	{
		return $this->description;
	}

	/**
	 * @param string|null $description
	 */
	public function setDescription(?string $description): void
	{
		$this->description = $description;
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
	 * @return int
	 */
	public function getStock(): int
	{
		return $this->stock;
	}

	/**
	 * @param int $stock
	 */
	public function setStock(int $stock): void
	{
		$this->stock = $stock;
	}

	/**
	 * @return int
	 */
	public function getPrice(): int
	{
		return $this->price;
	}

	/**
	 * @param int $price
	 */
	public function setPrice(int $price): void
	{
		$this->price = $price;
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
	 * @return ArrayCollection|ProductAttributeValueEntity[]
	 */
	public function getAttributeValues()
	{
		return $this->attributeValues;
	}

	/**
	 * @param ArrayCollection|ProductAttributeValueEntity[] $attributeValues
	 */
	public function setAttributeValues($attributeValues): void
	{
		$this->attributeValues = $attributeValues;
	}

	/**
	 * @return ArrayCollection|ProductImageEntity[]
	 */
	public function getImages()
	{
		return $this->images;
	}

	/**
	 * @param ArrayCollection|ProductImageEntity[] $images
	 */
	public function setImages($images): void
	{
		$this->images = $images;
	}
}