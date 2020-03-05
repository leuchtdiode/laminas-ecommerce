<?php
namespace Ecommerce\Db\Cart;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ecommerce\Db\Cart\Item\Entity as CartItemEntity;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Table(name="ecommerce_carts")
 * @ORM\Entity(repositoryClass="Ecommerce\Db\Cart\Repository")
 * @ORM\HasLifecycleCallbacks
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
	 * @var DateTime
	 *
	 * @ORM\Column(type="datetime");
	 */
	private $lastChangedDate;

	/**
	 * @var DateTime
	 *
	 * @ORM\Column(type="datetime");
	 */
	private $createdDate;

	/**
	 * @var ArrayCollection|CartItemEntity[]
	 *
	 * @ORM\OneToMany(targetEntity="Ecommerce\Db\Cart\Item\Entity", mappedBy="cart", cascade={"persist"})
	 */
	private $items;

	/**
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->id              = Uuid::uuid4();
		$this->lastChangedDate = new DateTime();
		$this->createdDate     = new DateTime();
		$this->items           = new ArrayCollection();
	}

	/**
	 * @ORM\PreFlush
	 * @throws Exception
	 */
	public function updateLastChangedDate()
	{
		$this->lastChangedDate = new DateTime();
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
	 * @return DateTime
	 */
	public function getLastChangedDate(): DateTime
	{
		return $this->lastChangedDate;
	}

	/**
	 * @param DateTime $lastChangedDate
	 */
	public function setLastChangedDate(DateTime $lastChangedDate): void
	{
		$this->lastChangedDate = $lastChangedDate;
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
	 * @return ArrayCollection|CartItemEntity[]
	 */
	public function getItems()
	{
		return $this->items;
	}

	/**
	 * @param ArrayCollection|CartItemEntity[] $items
	 */
	public function setItems($items): void
	{
		$this->items = $items;
	}
}