<?php
namespace Ecommerce\Tax;

use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class GetProvider
{
	private array $config;

	private ContainerInterface $container;

	public function __construct(array $config, ContainerInterface $container)
	{
		$this->config    = $config;
		$this->container = $container;
	}

	/**
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 */
	public function get(): RateProvider
	{
		$taxRateProvider = $this->container->get(
			$this->config['ecommerce']['taxRate']['provider']
		);

		if (!$taxRateProvider instanceof RateProvider)
		{
			throw new Exception(
				'No valid tax rate provider set (specify class in config: ecommerce->taxRate->provider'
			);
		}

		return $taxRateProvider;
	}
}