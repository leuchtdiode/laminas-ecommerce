<?php
namespace Ecommerce\Rest\Action\Cart;

use Common\Hydration\ObjectToArrayHydrator;
use Ecommerce\Cart\CouldNotFindCartError;
use Ecommerce\Cart\Provider;
use Ecommerce\Rest\Action\Base;
use Ecommerce\Rest\Action\LoginExempt;
use Ecommerce\Rest\Action\Response;
use Exception;
use Laminas\View\Model\JsonModel;

class Get extends Base implements LoginExempt
{
	private Provider $cartProvider;

	public function __construct(Provider $cartProvider)
	{
		$this->cartProvider = $cartProvider;
	}

	/**
	 * @throws Exception
	 */
	public function executeAction(): JsonModel
	{
		$cart = $this->cartProvider->byId(
			$this->params()->fromRoute('cartId')
		);

		if (!$cart)
		{
			return Response::is()
				->unsuccessful()
				->errors([ CouldNotFindCartError::create() ])
				->dispatch();
		}

		return Response::is()
			->successful()
			->data(
				ObjectToArrayHydrator::hydrate(
					GetSuccessData::create()
						->setCart($cart)
				)
			)
			->dispatch();
	}
}
