<?php
namespace Ecommerce\Payment\ReturnUrl;

class Provider
{
	private array $config;

	public function __construct(array $config)
	{
		$this->config = $config;
	}

	public function get(GetData $data): ?string
	{
		$callbackType = $data->getCallbackType();

		$config = $this->config['ecommerce']['payment']['returnUrls'];

		$url = $config[$callbackType];

		// possibility to set different return URL for each locale
		if (($locale = $data->getLocale()) && ($localeUrl = $config[$locale][$callbackType] ?? null))
		{
			$url = $localeUrl;
		}

		return $url;
	}
}