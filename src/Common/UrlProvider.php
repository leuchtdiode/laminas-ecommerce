<?php
namespace Ecommerce\Common;

use Laminas\Router\Http\TreeRouteStack;

class UrlProvider
{
	private array $config;

	private TreeRouteStack $router;

	public function __construct(array $config, TreeRouteStack $router)
	{
		$this->config = $config;
		$this->router = $router;
	}

	/**
	 * @param string[] $params
	 */
	public function get(string $routeName, array $params = []): string
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
