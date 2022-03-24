<?php
namespace Ecommerce\Db\Product\Attribute;

use Common\Db\Entity as DbEntity;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ecommerce\Db\Product\Attribute\Value\Entity as ProductAttributeValueEntity;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Table(name: 'ecommerce_product_attributes')]
#[ORM\UniqueConstraint(columns: [ 'processableId' ])]
#[ORM\Entity(repositoryClass: Repository::class)]
class Entity implements DbEntity
{
	#[ORM\Id]
	#[ORM\Column(type: 'uuid')]
	private UuidInterface $id;

	#[ORM\Column(type: 'string', length: 150)]
	private string $processableId;

	#[ORM\Column(type: 'string', length: 255)]
	private string $description;

	#[ORM\Column(type: 'string', length: 255, nullable: true)]
	private ?string $unit = null;

	#[ORM\Column(type: 'datetime')]
	private DateTime $createdDate;

	/**
	 * @var Collection|ProductAttributeValueEntity[]
	 */
	#[ORM\OneToMany(mappedBy: 'attribute', targetEntity: ProductAttributeValueEntity::class)]
	private Collection|array $attributeValues;

	/**
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->id              = Uuid::uuid4();
		$this->createdDate     = new DateTime();
		$this->attributeValues = new ArrayCollection();
	}

	public function getId(): UuidInterface
	{
		return $this->id;
	}

	public function setId(UuidInterface $id): void
	{
		$this->id = $id;
	}

	public function getProcessableId(): string
	{
		return $this->processableId;
	}

	public function setProcessableId(string $processableId): void
	{
		$this->processableId = $processableId;
	}

	public function getDescription(): string
	{
		return $this->description;
	}

	public function setDescription(string $description): void
	{
		$this->description = $description;
	}

	public function getUnit(): ?string
	{
		return $this->unit;
	}

	public function setUnit(?string $unit): void
	{
		$this->unit = $unit;
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
}