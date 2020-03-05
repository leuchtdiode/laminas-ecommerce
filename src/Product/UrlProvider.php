<?php
namespace Ecommerce\Product;

class UrlProvider
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
	 * @param $productId
	 * @param $productTitle
	 */
	public function get($productId)
	{
		$urlConfig = $this->config['ecommerce']['frontend']['url'] ?? null;

		return $urlConfig
			? sprintf(
				'%s://%s/product/%s',
				$urlConfig['protocol'],
				$urlConfig['host'],
				$productId
			)
			: null;
	}
}