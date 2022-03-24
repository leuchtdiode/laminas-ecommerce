<?php
namespace Ecommerce\Payment\ReturnUrl;

class GetData
{
	private string $callbackType;

	private ?string $locale = null;

	public static function create(): self
	{
		return new self();
	}

	public function getCallbackType(): string
	{
		return $this->callbackType;
	}

	public function setCallbackType(string $callbackType): GetData
	{
		$this->callbackType = $callbackType;
		return $this;
	}

	public function getLocale(): ?string
	{
		return $this->locale;
	}

	public function setLocale(?string $locale): GetData
	{
		$this->locale = $locale;
		return $this;
	}
}