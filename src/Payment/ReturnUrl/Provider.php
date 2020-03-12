<?php
namespace Ecommerce\Payment\ReturnUrl;

class Provider
{
	/**
	 * @var array
	 */
	private $config;

	/**
	 * @param array $config
	 */
	public function __construct(array $config)
	{
		$this->config = $config;
	}

	/**
	 * @param GetData $data
	 * @return string
	 */
	public function get(GetData $data)
	{
		$callbackType = $data->getCallbackType();

		$config = $this->config['ecommerce']['payment']['returnUrls'];

		$url = $config[$callbackType];

		// possibility to set different return URL for each locale
		if (($locale = $data->getLocale()) && ($localeUrl = $config[$locale][$callbackType]))
		{
			$url = $localeUrl;
		}

		return $url;
	}
}