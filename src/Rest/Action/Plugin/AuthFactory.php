<?php
namespace Ecommerce\Rest\Action\Plugin;

use Ecommerce\Customer\Auth\JwtHandler;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class AuthFactory implements FactoryInterface
{
	/**
	 * @param ContainerInterface $container
	 * @param string $requestedName
	 * @param array|null $options
	 * @return object
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 */
	public function __invoke(ContainerInterface $container, $requestedName, array $options = null): object
	{
		return new Auth(
			$container->get(JwtHandler::class)
		);
	}
}
