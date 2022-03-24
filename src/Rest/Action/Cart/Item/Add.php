<?php
namespace Ecommerce\Rest\Action\Cart\Item;

use Common\Hydration\ObjectToArrayHydrator;
use Ecommerce\Cart\CouldNotFindCartError;
use Ecommerce\Cart\Item\AddData as CartItemAddData;
use Ecommerce\Cart\Item\Adder;
use Ecommerce\Cart\Provider as CartProvider;
use Ecommerce\Rest\Action\Base;
use Ecommerce\Rest\Action\LoginExempt;
use Ecommerce\Rest\Action\Response;
use Exception;
use Laminas\View\Model\JsonModel;

class Add extends Base implements LoginExempt
{
	private AddData $data;

	private CartProvider $cartProvider;

	private Adder $adder;

	public function __construct(AddData $data, CartProvider $cartProvider, Adder $adder)
	{
		$this->data         = $data;
		$this->cartProvider = $cartProvider;
		$this->adder        = $adder;
	}

	/**
	 * @throws Exception
	 */
	public function executeAction(): JsonModel
	{
		$values = $this->data
			->setRequest($this->getRequest())
			->getValues();

		if ($values->hasErrors())
		{
			return Response::is()
				->unsuccessful()
				->errors($values->getErrors())
				->dispatch();
		}

		$cart = null;

		if (($cartId = $this->params()->fromRoute('cartId')))
		{
			$cart = $this->cartProvider->byId($cartId);

			if (!$cart)
			{
				return Response::is()
					->unsuccessful()
					->errors([ CouldNotFindCartError::create() ])
					->dispatch();
			}
		}

		$addResult = $this->adder->add(
			CartItemAddData::create()
				->setCart($cart)
				->setProductId($values->get(AddData::PRODUCT_ID)
					->getValue())
				->setAmount($values->get(AddData::AMOUNT)
					->getValue())
		);

		if (!$addResult->isSuccess())
		{
			return Response::is()
				->unsuccessful()
				->errors($addResult->getErrors())
				->dispatch();
		}

		return Response::is()
			->successful()
			->data(
				ObjectToArrayHydrator::hydrate(
					AddSuccessData::create()
						->setCart($addResult->getCart())
				)
			)
			->dispatch();
	}
}
