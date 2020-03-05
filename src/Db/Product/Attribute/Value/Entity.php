<?php
namespace Ecommerce\Db\Product\Attribute\Value;

use Doctrine\ORM\Mapping as ORM;
use Ecommerce\Db\Product\Attribute\Entity as ProductAttributeEntity;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Table(name="ecommerce_product_attribute_values")
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
	 * @ORM\Column(type="string", length=255)
	 */
	private $value;

	/**
	 * @var ProductAttributeEntity
	 *
	 * @ORM\ManyToOne(targetEntity="Ecommerce\Db\Product\Attribute\Entity", inversedBy="attributes")
	 * @ORM\JoinColumn(name="attributeId", referencedColumnName="id", nullable=false)
	 */
	private $attribute;

	/**
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->id = Uuid::uuid4();
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
	public function getValue(): string
	{
		return $this->value;
	}

	/**
	 * @param string $value
	 */
	public function setValue(string $value): void
	{
		$this->value = $value;
	}

	/**
	 * @return ProductAttributeEntity
	 */
	public function getAttribute(): ProductAttributeEntity
	{
		return $this->attribute;
	}

	/**
	 * @param ProductAttributeEntity $attribute
	 */
	public function setAttribute(ProductAttributeEntity $attribute): void
	{
		$this->attribute = $attribute;
	}
}