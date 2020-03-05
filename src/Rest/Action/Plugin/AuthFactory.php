<?php
namespace Ecommerce\Rest\Action\Plugin;

use Ecommerce\Customer\Auth\JwtHandler;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class AuthFactory implements FactoryInterface
{
	/**
	 * @param ContainerInterface $container
	 * @param string $requestedName
	 * @param array|null $options
	 * @return Auth|object
	 */
	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
		return new Auth(
			$container->get(JwtHandler::class)
		);
	}
}
