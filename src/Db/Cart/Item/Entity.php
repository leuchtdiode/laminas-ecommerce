<?php
namespace Ecommerce\Db\Cart\Item;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Ecommerce\Db\Cart\Entity as CartEntity;
use Ecommerce\Db\Product\Entity as ProductEntity;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Table(name="ecommerce_cart_items")
 * @ORM\Entity(repositoryClass="Ecommerce\Db\Cart\Item\Repository")
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
	 * @var int
	 *
	 * @ORM\Column(type="integer")
	 */
	private $quantity;

	/**
	 * @var DateTime
	 *
	 * @ORM\Column(type="datetime");
	 */
	private $createdDate;

	/**
	 * @var ProductEntity
	 *
	 * @ORM\ManyToOne(targetEntity="Ecommerce\Db\Product\Entity")
	 * @ORM\JoinColumn(name="productId", referencedColumnName="id", nullable=false)
	 */
	private $product;

	/**
	 * @var CartEntity
	 *
	 * @ORM\ManyToOne(targetEntity="Ecommerce\Db\Cart\Entity", inversedBy="items")
	 * @ORM\JoinColumn(name="cartId", referencedColumnName="id", nullable=false)
	 */
	private $cart;

	/**
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->id          = Uuid::uuid4();
		$this->createdDate = new DateTime();
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
	 * @return int
	 */
	public function getQuantity(): int
	{
		return $this->quantity;
	}

	/**
	 * @param int $quantity
	 */
	public function setQuantity(int $quantity): void
	{
		$this->quantity = $quantity;
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

	/**
	 * @return CartEntity
	 */
	public function getCart(): CartEntity
	{
		return $this->cart;
	}

	/**
	 * @param CartEntity $cart
	 */
	public function setCart(CartEntity $cart): void
	{
		$this->cart = $cart;
	}
}