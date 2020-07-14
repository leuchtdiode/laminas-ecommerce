<?php
namespace Ecommerce\Tax;

use Exception;
use Psr\Container\ContainerInterface;

class GetProvider
{
	/**
	 * @var array
	 */
	private $config;

	/**
	 * @var ContainerInterface
	 */
	private $container;

	/**
	 * @param array $config
	 * @param ContainerInterface $container
	 */
	public function __construct(array $config, ContainerInterface $container)
	{
		$this->config    = $config;
		$this->container = $container;
	}

	/**
	 * @return RateProvider
	 * @throws Exception
	 */
	public function get()
	{
		$taxRateProvider = $this->container->get(
			$this->config['ecommerce']['taxRate']['provider']
		);

		if (!$taxRateProvider || !$taxRateProvider instanceof RateProvider)
		{
			throw new Exception(
				'No valid tax rate provider set (specify class in config: ecommerce->taxRate->provider'
			);
		}

		return $taxRateProvider;
	}
}