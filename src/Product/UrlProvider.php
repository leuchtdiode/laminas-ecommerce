<?php
namespace Ecommerce\Product;

class UrlProvider
{
	private array $config;

	public function __construct(array $config)
	{
		$this->config = $config;
	}

	public function get(string $productId): ?String
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