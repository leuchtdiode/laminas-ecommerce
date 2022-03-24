<?php
namespace Ecommerce\Customer\Auth;

use Ecommerce\Address\AddModifyData as AddressAddModifyData;

class RegisterData
{
	private string $email;

	private string $password;

	private string $passwordVerify;

	private string $salutation;

	private ?string $title = null;

	private string $firstName;

	private string $lastName;

	private ?string $company = null;

	private ?string $taxNumber = null;

	private AddressAddModifyData $addressData;

	public static function create(): self
	{
		return new self();
	}

	public function getEmail(): string
	{
		return $this->email;
	}

	public function setEmail(string $email): RegisterData
	{
		$this->email = $email;
		return $this;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	public function setPassword(string $password): RegisterData
	{
		$this->password = $password;
		return $this;
	}

	public function getPasswordVerify(): string
	{
		return $this->passwordVerify;
	}

	public function setPasswordVerify(string $passwordVerify): RegisterData
	{
		$this->passwordVerify = $passwordVerify;
		return $this;
	}

	public function getSalutation(): string
	{
		return $this->salutation;
	}

	public function setSalutation(string $salutation): RegisterData
	{
		$this->salutation = $salutation;
		return $this;
	}

	public function getTitle(): ?string
	{
		return $this->title;
	}

	public function setTitle(?string $title): RegisterData
	{
		$this->title = $title;
		return $this;
	}

	public function getFirstName(): string
	{
		return $this->firstName;
	}

	public function setFirstName(string $firstName): RegisterData
	{
		$this->firstName = $firstName;
		return $this;
	}

	public function getLastName(): string
	{
		return $this->lastName;
	}

	public function setLastName(string $lastName): RegisterData
	{
		$this->lastName = $lastName;
		return $this;
	}

	public function getCompany(): ?string
	{
		return $this->company;
	}

	public function setCompany(?string $company): RegisterData
	{
		$this->company = $company;
		return $this;
	}

	public function getTaxNumber(): ?string
	{
		return $this->taxNumber;
	}

	public function setTaxNumber(?string $taxNumber): RegisterData
	{
		$this->taxNumber = $taxNumber;
		return $this;
	}

	public function getAddressData(): AddressAddModifyData
	{
		return $this->addressData;
	}

	public function setAddressData(AddressAddModifyData $addressData): RegisterData
	{
		$this->addressData = $addressData;
		return $this;
	}
}