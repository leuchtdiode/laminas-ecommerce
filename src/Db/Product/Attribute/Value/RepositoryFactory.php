<?php
namespace Ecommerce\Db\Product\Attribute\Value;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class RepositoryFactory implements FactoryInterface
{
	/**
	 * @param ContainerInterface $container
	 * @param string $requestedName
	 * @param array|null $options
	 * @return Repository
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
