<?php
namespace Ecommerce\Rest\Action\Product;

use Common\Hydration\ObjectToArrayHydrator;
use Ecommerce\Product\Provider;
use Ecommerce\Rest\Action\Base;
use Ecommerce\Rest\Action\LoginExempt;
use Ecommerce\Rest\Action\Response;
use Exception;
use Laminas\View\Model\JsonModel;

class Get extends Base implements LoginExempt
{
	/**
	 * @var Provider
	 */
	private $provider;

	/**
	 * @param Provider $provider
	 */
	public function __construct(Provider $provider)
	{
		$this->provider = $provider;
	}

	/**
	 * @return JsonModel
	 * @throws Exception
	 */
	public function executeAction()
	{
		$product = $this->provider->byId(
			$this
				->params()
				->fromRoute('productId')
		);

		if (!$product)
		{
			return Response::is()
				->unsuccessful()
				->dispatch();
		}

		return Response::is()
			->successful()
			->data(
				ObjectToArrayHydrator::hydrate(
					$product
				)
			)
			->dispatch();
	}
}
