<?php
namespace Ecommerce\Db\Product\Image;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class RepositoryFactory implements FactoryInterface
{

	/**
	 * Create an object
	 *
	 * @param  ContainerInterface $container
	 * @param  string $requestedName
	 * @param  null|array $options
	 * @return object
	 */
	public function __invoke(
		ContainerInterface $container,
		$requestedName,
		array $options = null
	)
	{
		return $container
			->get(EntityManager::class)
			->getRepository(Entity::class);
	}
}
