<?php
namespace Ecommerce\Customer\Auth;

use Ecommerce\Address\AddModifyData as AddressAddModifyData;

class RegisterData
{
	/**
	 * @var string
	 */
	private $email;

	/**
	 * @var string
	 */
	private $password;

	/**
	 * @var string
	 */
	private $passwordVerify;

	/**
	 * @var string
	 */
	private $salutation;

	/**
	 * @var string|null
	 */
	private $title;

	/**
	 * @var string
	 */
	private $firstName;

	/**
	 * @var string
	 */
	private $lastName;

	/**
	 * @var string|null
	 */
	private $company;

	/**
	 * @var string|null
	 */
	private $taxNumber;

	/**
	 * @var AddressAddModifyData
	 */
	private $addressData;

	/**
	 * @return RegisterData
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->email;
	}

	/**
	 * @param string $email
	 * @return RegisterData
	 */
	public function setEmail(string $email): RegisterData
	{
		$this->email = $email;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPassword(): string
	{
		return $this->password;
	}

	/**
	 * @param string $password
	 * @return RegisterData
	 */
	public function setPassword(string $password): RegisterData
	{
		$this->password = $password;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPasswordVerify(): string
	{
		return $this->passwordVerify;
	}

	/**
	 * @param string $passwordVerify
	 * @return RegisterData
	 */
	public function setPasswordVerify(string $passwordVerify): RegisterData
	{
		$this->passwordVerify = $passwordVerify;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getSalutation(): string
	{
		return $this->salutation;
	}

	/**
	 * @param string $salutation
	 * @return RegisterData
	 */
	public function setSalutation(string $salutation): RegisterData
	{
		$this->salutation = $salutation;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getTitle(): ?string
	{
		return $this->title;
	}

	/**
	 * @param string|null $title
	 * @return RegisterData
	 */
	public function setTitle(?string $title): RegisterData
	{
		$this->title = $title;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getFirstName(): string
	{
		return $this->firstName;
	}

	/**
	 * @param string $firstName
	 * @return RegisterData
	 */
	public function setFirstName(string $firstName): RegisterData
	{
		$this->firstName = $firstName;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getLastName(): string
	{
		return $this->lastName;
	}

	/**
	 * @param string $lastName
	 * @return RegisterData
	 */
	public function setLastName(string $lastName): RegisterData
	{
		$this->lastName = $lastName;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getCompany(): ?string
	{
		return $this->company;
	}

	/**
	 * @param string|null $company
	 * @return RegisterData
	 */
	public function setCompany(?string $company): RegisterData
	{
		$this->company = $company;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getTaxNumber(): ?string
	{
		return $this->taxNumber;
	}

	/**
	 * @param string|null $taxNumber
	 * @return RegisterData
	 */
	public function setTaxNumber(?string $taxNumber): RegisterData
	{
		$this->taxNumber = $taxNumber;
		return $this;
	}

	/**
	 * @return AddressAddModifyData
	 */
	public function getAddressData(): AddressAddModifyData
	{
		return $this->addressData;
	}

	/**
	 * @param AddressAddModifyData $addressData
	 * @return RegisterData
	 */
	public function setAddressData(AddressAddModifyData $addressData): RegisterData
	{
		$this->addressData = $addressData;
		return $this;
	}
}