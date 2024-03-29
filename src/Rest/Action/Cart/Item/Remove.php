<?php
namespace Ecommerce\Rest\Action\Cart\Item;

use Ecommerce\Cart\Item\CouldNotFindCartItemError;
use Ecommerce\Cart\Item\Provider;
use Ecommerce\Cart\Item\Remover;
use Ecommerce\Rest\Action\Base;
use Ecommerce\Rest\Action\LoginExempt;
use Ecommerce\Rest\Action\Response;
use Exception;
use Laminas\View\Model\JsonModel;

class Remove extends Base implements LoginExempt
{
	private Provider $provider;

	private Remover $remover;

	public function __construct(Provider $provider, Remover $remover)
	{
		$this->provider = $provider;
		$this->remover  = $remover;
	}

	/**
	 * @throws Exception
	 */
	public function executeAction(): JsonModel
	{
		$cartItem = $this->provider->byId(
			$this->params()->fromRoute('cartItemId')
		);

		if (!$cartItem)
		{
			return Response::is()
				->unsuccessful()
				->errors([ CouldNotFindCartItemError::create() ])
				->dispatch();
		}

		$removeResult = $this->remover->remove($cartItem);

		if (!$removeResult)
		{
			return Response::is()
				->unsuccessful()
				->errors($removeResult->getErrors())
				->dispatch();
		}

		return Response::is()
			->successful()
			->dispatch();
	}
}
