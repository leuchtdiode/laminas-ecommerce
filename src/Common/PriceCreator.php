<?php
namespace Ecommerce\Common;

class PriceCreator
{
	private array $config;

	public function __construct(array $config)
	{
		$this->config = $config;
	}

	public function fromCents(int $cents, ?int $taxRate = null): Price
	{
		return Price::fromCents(
			$cents,
			$taxRate ?? $this->config['ecommerce']['taxRate']['default']
		);
	}
}