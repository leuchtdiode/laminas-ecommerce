<?php
namespace Ecommerce\Db\Product\Attribute\Value;

use Common\Db\Entity as DbEntity;
use Doctrine\ORM\Mapping as ORM;
use Ecommerce\Db\Product\Attribute\Entity as ProductAttributeEntity;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Table(name: 'ecommerce_product_attribute_values')]
#[ORM\Entity(repositoryClass: Repository::class)]
class Entity implements DbEntity
{
	#[ORM\Id]
	#[ORM\Column(type: 'uuid')]
	private UuidInterface $id;

	#[ORM\Column(type: 'string', length: 255)]
	private string $value;

	#[ORM\ManyToOne(targetEntity: ProductAttributeEntity::class, inversedBy: 'attributes')]
	#[ORM\JoinColumn(name: 'attributeId', nullable: false, onDelete: 'CASCADE')]
	private ProductAttributeEntity $attribute;

	/**
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->id = Uuid::uuid4();
	}

	public function getId(): UuidInterface
	{
		return $this->id;
	}

	public function setId(UuidInterface $id): void
	{
		$this->id = $id;
	}

	public function getValue(): string
	{
		return $this->value;
	}

	public function setValue(string $value): void
	{
		$this->value = $value;
	}

	public function getAttribute(): ProductAttributeEntity
	{
		return $this->attribute;
	}

	public function setAttribute(ProductAttributeEntity $attribute): void
	{
		$this->attribute = $attribute;
	}
}