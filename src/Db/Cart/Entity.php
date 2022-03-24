<?php
namespace Ecommerce\Db\Cart;

use Common\Db\Entity as DbEntity;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ecommerce\Db\Cart\Item\Entity as CartItemEntity;
use Exception;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Table(name: 'ecommerce_carts')]
#[ORM\Entity(repositoryClass: Repository::class)]
#[ORM\HasLifecycleCallbacks]
class Entity implements DbEntity
{
	#[ORM\Id]
	#[ORM\Column(type: 'uuid')]
	private UuidInterface $id;

	#[ORM\Column(type: 'datetime')]
	private DateTime $lastChangedDate;

	#[ORM\Column(type: 'datetime')]
	private DateTime $createdDate;

	/**
	 * @var ArrayCollection|CartItemEntity[]
	 */
	#[ORM\OneToMany(mappedBy: 'cart', targetEntity: CartItemEntity::class, cascade: [ 'persist'])]
	private Collection|array $items;

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
	 * @throws Exception
	 */
	#[ORM\PreFlush]
	public function updateLastChangedDate()
	{
		$this->lastChangedDate = new DateTime();
	}

	public function getId(): UuidInterface
	{
		return $this->id;
	}

	public function setId(UuidInterface $id): void
	{
		$this->id = $id;
	}

	public function getLastChangedDate(): DateTime
	{
		return $this->lastChangedDate;
	}

	public function setLastChangedDate(DateTime $lastChangedDate): void
	{
		$this->lastChangedDate = $lastChangedDate;
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
	 * @return ArrayCollection|CartItemEntity[]
	 */
	public function getItems(): Collection|array
	{
		return $this->items;
	}

	/**
	 * @param ArrayCollection|CartItemEntity[] $items
	 */
	public function setItems(Collection|array $items): void
	{
		$this->items = $items;
	}
}