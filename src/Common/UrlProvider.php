<?php
namespace Ecommerce\Common;

use Laminas\Router\Http\TreeRouteStack;

class UrlProvider
{
	/**
	 * @var array
	 */
	private $config;

	/**
	 * @var TreeRouteStack
	 */
	private $router;

	/**
	 * @param array $config
	 * @param TreeRouteStack $router
	 */
	public function __construct(array $config, TreeRouteStack $router)
	{
		$this->config = $config;
		$this->router = $router;
	}

	/**
	 * @param string $routeName
	 * @param string[] $params
	 * @return string
	 */
	public function get($routeName, $params = [])
	{
		return sprintf(
			'%s://%s%s',
			$this->config['ecommerce']['url']['protocol'],
			$this->config['ecommerce']['url']['host'],
			$this->router->assemble(
				$params,
				[
					'name' => $routeName
				]
			)
		);
	}
}
