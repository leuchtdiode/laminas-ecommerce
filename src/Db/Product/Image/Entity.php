<?php
namespace Ecommerce\Db\Product\Image;

use Assets\Db\File\Entity as AssetFileEntity;
use Doctrine\ORM\Mapping as ORM;
use Ecommerce\Db\Product\Entity as ProductEntity;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Table(name="ecommerce_product_images")
 * @ORM\Entity(repositoryClass="Ecommerce\Db\Product\Image\Repository")
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
	 * @var bool
	 *
	 * @ORM\Column(type="boolean")
	 */
	private $main;

	/**
	 * @var int
	 *
	 * @ORM\Column(type="integer")
	 */
	private $sort;

	/**
	 * @var AssetFileEntity
	 *
	 * @ORM\ManyToOne(targetEntity="Assets\Db\File\Entity")
	 * @ORM\JoinColumn(name="fileId", referencedColumnName="id", nullable=false)
	 */
	private $file;

	/**
	 * @var ProductEntity
	 *
	 * @ORM\ManyToOne(targetEntity="Ecommerce\Db\Product\Entity", inversedBy="images")
	 * @ORM\JoinColumn(name="productId", referencedColumnName="id", nullable=false)
	 */
	private $product;

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
	 * @return bool
	 */
	public function isMain(): bool
	{
		return $this->main;
	}

	/**
	 * @param bool $main
	 */
	public function setMain(bool $main): void
	{
		$this->main = $main;
	}

	/**
	 * @return int
	 */
	public function getSort(): int
	{
		return $this->sort;
	}

	/**
	 * @param int $sort
	 */
	public function setSort(int $sort): void
	{
		$this->sort = $sort;
	}

	/**
	 * @return AssetFileEntity
	 */
	public function getFile(): AssetFileEntity
	{
		return $this->file;
	}

	/**
	 * @param AssetFileEntity $file
	 */
	public function setFile(AssetFileEntity $file): void
	{
		$this->file = $file;
	}

	/**
	 * @return ProductEntity
	 */
	public function getProduct(): ProductEntity
	{
		return $this->product;
	}

	/**
	 * @param ProductEntity $product
	 */
	public function setProduct(ProductEntity $product): void
	{
		$this->product = $product;
	}
}