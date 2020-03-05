<?php
namespace Ecommerce\Payment\MethodHandler;

use RuntimeException;
use Ecommerce\Payment\Method;
use Psr\Container\ContainerInterface;

class Provider
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
	 * @param Method $paymentMethod
	 * @return MethodHandler
	 * @throws RuntimeException
	 */
	public function getHandler(Method $paymentMethod)
	{
		$id = $paymentMethod->getId();

		$methodHandlerClass = $this->config['ecommerce']['payment']['method'][$id]['handler'] ?? null;

		if (!$methodHandlerClass)
		{
			throw new RuntimeException('Method handler class is not set in config (' . $id . ')');
		}

		$handler = $this->container->get($methodHandlerClass);

		if (!$handler)
		{
			throw new RuntimeException('Method handler not found in container (' . $id . ')');
		}

		return $handler;
	}
}