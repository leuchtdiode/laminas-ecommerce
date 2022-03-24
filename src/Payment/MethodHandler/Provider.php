<?php
namespace Ecommerce\Payment\MethodHandler;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use RuntimeException;
use Ecommerce\Payment\Method;
use Psr\Container\ContainerInterface;

class Provider
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
	public function getHandler(Method $paymentMethod): MethodHandler
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