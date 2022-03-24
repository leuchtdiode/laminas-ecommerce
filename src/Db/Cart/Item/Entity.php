<?php
namespace Ecommerce\Db\Cart\Item;

use Common\Db\Entity as DbEntity;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Ecommerce\Db\Cart\Entity as CartEntity;
use Ecommerce\Db\Product\Entity as ProductEntity;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Table(name: 'ecommerce_cart_items')]
#[ORM\Entity(repositoryClass: Repository::class)]
class Entity implements DbEntity
{
	#[ORM\Id]
	#[ORM\Column(type: 'uuid')]
	private UuidInterface $id;

	#[ORM\Column(type: 'integer')]
	private int $quantity;

	#[ORM\Column(type: 'datetime')]
	private DateTime $createdDate;

	#[ORM\ManyToOne(targetEntity: ProductEntity::class)]
	#[ORM\JoinColumn(name: 'productId', nullable: false)]
	private ProductEntity $product;

	#[ORM\ManyToOne(targetEntity: CartEntity::class, inversedBy: 'items')]
	#[ORM\JoinColumn(name: 'cartId', nullable: false)]
	private CartEntity $cart;

	/**
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->id          = Uuid::uuid4();
		$this->createdDate = new DateTime();
	}

	public function getId(): UuidInterface
	{
		return $this->id;
	}

	public function setId(UuidInterface $id): void
	{
		$this->id = $id;
	}

	public function getQuantity(): int
	{
		return $this->quantity;
	}

	public function setQuantity(int $quantity): void
	{
		$this->quantity = $quantity;
	}

	public function getCreatedDate(): DateTime
	{
		return $this->createdDate;
	}

	public function setCreatedDate(DateTime $createdDate): void
	{
		$this->createdDate = $createdDate;
	}

	public function getProduct(): ProductEntity
	{
		return $this->product;
	}

	public function setProduct(ProductEntity $product): void
	{
		$this->product = $product;
	}

	public function getCart(): CartEntity
	{
		return $this->cart;
	}

	public function setCart(CartEntity $cart): void
	{
		$this->cart = $cart;
	}
}