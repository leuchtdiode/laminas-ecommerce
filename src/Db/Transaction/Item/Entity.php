<?php
namespace Ecommerce\Db\Transaction\Item;

use Common\Db\Entity as DbEntity;
use Doctrine\ORM\Mapping as ORM;
use Ecommerce\Db\Product\Entity as ProductEntity;
use Ecommerce\Db\Transaction\Entity as TransactionEntity;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Table(name: 'ecommerce_transaction_items')]
#[ORM\Entity(repositoryClass: Repository::class)]
class Entity implements DbEntity
{
	#[ORM\Id]
	#[ORM\Column(type: 'uuid')]
	private UuidInterface $id;

	#[ORM\Column(type: 'integer')]
	private int $price;

	#[ORM\Column(type: 'integer')]
	private int $tax;

	#[ORM\Column(type: 'integer')]
	private int $amount;

	#[ORM\ManyToOne(targetEntity: ProductEntity::class)]
	#[ORM\JoinColumn(name: 'productId', nullable: false)]
	private ProductEntity $product;

	#[ORM\ManyToOne(targetEntity: TransactionEntity::class, cascade: [ 'persist'], inversedBy: 'items')]
	#[ORM\JoinColumn(name: 'transactionId', nullable: false)]
	private TransactionEntity $transaction;

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

	public function getPrice(): int
	{
		return $this->price;
	}

	public function setPrice(int $price): void
	{
		$this->price = $price;
	}

	public function getTax(): int
	{
		return $this->tax;
	}

	public function setTax(int $tax): void
	{
		$this->tax = $tax;
	}

	public function getAmount(): int
	{
		return $this->amount;
	}

	public function setAmount(int $amount): void
	{
		$this->amount = $amount;
	}

	public function getProduct(): ProductEntity
	{
		return $this->product;
	}

	public function setProduct(ProductEntity $product): void
	{
		$this->product = $product;
	}

	public function getTransaction(): TransactionEntity
	{
		return $this->transaction;
	}

	public function setTransaction(TransactionEntity $transaction): void
	{
		$this->transaction = $transaction;
	}
}