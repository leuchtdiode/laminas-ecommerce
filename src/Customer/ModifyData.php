<?php
namespace Ecommerce\Customer;

class ModifyData
{
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
	 * @return ModifyData
	 */
	public static function create()
	{
		return new self();
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
	 * @return ModifyData
	 */
	public function setSalutation(string $salutation): ModifyData
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
	 * @return ModifyData
	 */
	public function setTitle(?string $title): ModifyData
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
	 * @return ModifyData
	 */
	public function setFirstName(string $firstName): ModifyData
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
	 * @return ModifyData
	 */
	public function setLastName(string $lastName): ModifyData
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
	 * @return ModifyData
	 */
	public function setCompany(?string $company): ModifyData
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
	 * @return ModifyData
	 */
	public function setTaxNumber(?string $taxNumber): ModifyData
	{
		$this->taxNumber = $taxNumber;
		return $this;
	}
}