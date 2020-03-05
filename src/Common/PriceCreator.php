<?php
namespace Ecommerce\Common;

class PriceCreator
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
	 * @param $cents
	 * @param null|int $taxRate
	 * @return Price
	 */
	public function fromCents($cents, $taxRate = null)
	{
		return Price::fromCents(
			$cents,
			$taxRate ?? $this->config['ecommerce']['defaultTaxRate']
		);
	}
}