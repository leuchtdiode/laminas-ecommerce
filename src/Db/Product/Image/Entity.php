<?php
namespace Ecommerce\Db\Product\Image;

use Assets\Db\File\Entity as AssetFileEntity;
use Common\Db\Entity as DbEntity;
use Doctrine\ORM\Mapping as ORM;
use Ecommerce\Db\Product\Entity as ProductEntity;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Table(name: 'ecommerce_product_images')]
#[ORM\Entity(repositoryClass: Repository::class)]
class Entity implements DbEntity
{
	#[ORM\Id]
	#[ORM\Column(type: 'uuid')]
	private UuidInterface $id;

	#[ORM\Column(type: 'boolean')]
	private bool $main;

	#[ORM\Column(type: 'integer')]
	private int $sort;

	#[ORM\ManyToOne(targetEntity: AssetFileEntity::class)]
	#[ORM\JoinColumn(name: 'fileId', nullable: false)]
	private AssetFileEntity $file;

	#[ORM\ManyToOne(targetEntity: ProductEntity::class, inversedBy: 'images')]
	#[ORM\JoinColumn(name: 'productId', nullable: false)]
	private ProductEntity $product;

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

	public function isMain(): bool
	{
		return $this->main;
	}

	public function setMain(bool $main): void
	{
		$this->main = $main;
	}

	public function getSort(): int
	{
		return $this->sort;
	}

	public function setSort(int $sort): void
	{
		$this->sort = $sort;
	}

	public function getFile(): AssetFileEntity
	{
		return $this->file;
	}

	public function setFile(AssetFileEntity $file): void
	{
		$this->file = $file;
	}

	public function getProduct(): ProductEntity
	{
		return $this->product;
	}

	public function setProduct(ProductEntity $product): void
	{
		$this->product = $product;
	}
}