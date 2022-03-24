<?php
namespace Ecommerce\Customer;

class ModifyData
{
	private string $salutation;

	private ?string $title = null;

	private string $firstName;

	private string $lastName;

	private ?string $company = null;

	private ?string $taxNumber = null;

	public static function create(): self
	{
		return new self();
	}

	public function getSalutation(): string
	{
		return $this->salutation;
	}

	public function setSalutation(string $salutation): ModifyData
	{
		$this->salutation = $salutation;
		return $this;
	}

	public function getTitle(): ?string
	{
		return $this->title;
	}

	public function setTitle(?string $title): ModifyData
	{
		$this->title = $title;
		return $this;
	}

	public function getFirstName(): string
	{
		return $this->firstName;
	}

	public function setFirstName(string $firstName): ModifyData
	{
		$this->firstName = $firstName;
		return $this;
	}

	public function getLastName(): string
	{
		return $this->lastName;
	}

	public function setLastName(string $lastName): ModifyData
	{
		$this->lastName = $lastName;
		return $this;
	}

	public function getCompany(): ?string
	{
		return $this->company;
	}

	public function setCompany(?string $company): ModifyData
	{
		$this->company = $company;
		return $this;
	}

	public function getTaxNumber(): ?string
	{
		return $this->taxNumber;
	}

	public function setTaxNumber(?string $taxNumber): ModifyData
	{
		$this->taxNumber = $taxNumber;
		return $this;
	}
}