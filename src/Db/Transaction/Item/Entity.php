<?php
namespace Ecommerce\Db\Transaction\Item;

use Doctrine\ORM\Mapping as ORM;
use Ecommerce\Db\Product\Entity as ProductEntity;
use Ecommerce\Db\Transaction\Entity as TransactionEntity;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Table(name="ecommerce_transaction_items")
 * @ORM\Entity(repositoryClass="Ecommerce\Db\Transaction\Item\Repository")
 */
class Entity
{
	/**
	 * @var UuidInterface
	 *
	 * @ORM\Id
	 * @ORM\Column(type="uuid")
	 */
	private $id;

	/**
	 * @var int
	 *
	 * @ORM\Column(type="integer")
	 */
	private $price;

	/**
	 * @var int
	 *
	 * @ORM\Column(type="integer")
	 */
	private $tax;

	/**
	 * @var int
	 *
	 * @ORM\Column(type="integer")
	 */
	private $amount;

	/**
	 * @var ProductEntity
	 *
	 * @ORM\ManyToOne(targetEntity="Ecommerce\Db\Product\Entity")
	 * @ORM\JoinColumn(name="productId", referencedColumnName="id", nullable=false)
	 */
	private $product;

	/**
	 * @var TransactionEntity
	 *
	 * @ORM\ManyToOne(targetEntity="Ecommerce\Db\Transaction\Entity", inversedBy="items", cascade={"persist"})
	 * @ORM\JoinColumn(name="transactionId", referencedColumnName="id", nullable=false)
	 */
	private $transaction;

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
	 * @return int
	 */
	public function getAmount(): int
	{
		return $this->amount;
	}

	/**
	 * @param int $amount
	 */
	public function setAmount(int $amount): void
	{
		$this->amount = $amount;
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
	 * @return int
	 */
	public function getTax(): int
	{
		return $this->tax;
	}

	/**
	 * @param int $tax
	 */
	public function setTax(int $tax): void
	{
		$this->tax = $tax;
	}

	/**
	 * @return TransactionEntity
	 */
	public function getTransaction(): TransactionEntity
	{
		return $this->transaction;
	}

	/**
	 * @param TransactionEntity $transaction
	 */
	public function setTransaction(TransactionEntity $transaction): void
	{
		$this->transaction = $transaction;
	}
}