<?php
namespace Ecommerce\Customer;

use Common\Dto\Dto;
use Common\Hydration\ArrayHydratable;
use Common\Hydration\ObjectToArrayHydratorProperty;
use DateTime;
use Ecommerce\Db\Customer\Entity;
use Ramsey\Uuid\UuidInterface;

class Customer implements Dto, ArrayHydratable
{
	private Entity $entity;

	#[ObjectToArrayHydratorProperty]
	private Status $status;

	#[ObjectToArrayHydratorProperty]
	private Salutation $salutation;

	public function __construct(Entity $entity, Status $status, Salutation $salutation)
	{
		$this->entity     = $entity;
		$this->status     = $status;
		$this->salutation = $salutation;
	}

	public function equals(Customer $customer): bool
	{
		return $this->getId()->equals($customer->getId());
	}

	public function hasCompany(): bool
	{
		$company = $this->getCompany();

		return !empty($company);
	}

	#[ObjectToArrayHydratorProperty]
	public function getName(): string
	{
		return $this->getFirstName() . ' ' . $this->getLastName();
	}

	public function getStatus(): Status
	{
		return $this->status;
	}

	public function getSalutation(): Salutation
	{
		return $this->salutation;
	}

	#[ObjectToArrayHydratorProperty]
	public function getId(): UuidInterface
	{
		return $this->entity->getId();
	}

	#[ObjectToArrayHydratorProperty]
	public function getEmail(): string
	{
		return $this->entity->getEmail();
	}

	public function getPassword(): string
	{
		return $this->entity->getPassword();
	}

	#[ObjectToArrayHydratorProperty]
	public function getFirstName(): string
	{
		return $this->entity->getFirstName();
	}

	#[ObjectToArrayHydratorProperty]
	public function getLastName(): string
	{
		return $this->entity->getLastName();
	}

	#[ObjectToArrayHydratorProperty]
	public function getTitle(): ?string
	{
		return $this->entity->getTitle();
	}

	#[ObjectToArrayHydratorProperty]
	public function getCompany(): ?string
	{
		return $this->entity->getCompany();
	}

	#[ObjectToArrayHydratorProperty]
	public function getTaxNumber(): ?string
	{
		return $this->entity->getTaxNumber();
	}

	#[ObjectToArrayHydratorProperty]
	public function getForgotPasswordHash(): ?string
	{
		return $this->entity->getForgotPasswordHash();
	}

	#[ObjectToArrayHydratorProperty]
	public function getLocale(): ?string
	{
		return $this->entity->getLocale();
	}

	#[ObjectToArrayHydratorProperty]
	public function getCreatedDate(): DateTime
	{
		return $this->entity->getCreatedDate();
	}

	public function getEntity(): Entity
	{
		return $this->entity;
	}
}