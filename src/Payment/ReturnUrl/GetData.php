<?php
namespace Ecommerce\Payment\ReturnUrl;

class GetData
{
	/**
	 * @var string
	 */
	private $callbackType;

	/**
	 * @var string|null
	 */
	private $locale;

	/**
	 * @return self
	 */
	public static function create()
	{
		return new self();
	}

	/**
	 * @return string
	 */
	public function getCallbackType(): string
	{
		return $this->callbackType;
	}

	/**
	 * @param string $callbackType
	 * @return GetData
	 */
	public function setCallbackType(string $callbackType): GetData
	{
		$this->callbackType = $callbackType;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getLocale(): ?string
	{
		return $this->locale;
	}

	/**
	 * @param string|null $locale
	 * @return GetData
	 */
	public function setLocale(?string $locale): GetData
	{
		$this->locale = $locale;
		return $this;
	}
}