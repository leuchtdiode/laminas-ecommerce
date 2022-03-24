<?php
namespace Ecommerce\Cart\Item;

use Ecommerce\Cart\Adder as CartAdder;
use Ecommerce\Cart\Cart;
use Ecommerce\Cart\Provider as CartProvider;
use Ecommerce\Db\Cart\Item\Entity as ItemEntity;
use Ecommerce\Db\Cart\Item\Saver as CartItemEntitySaver;
use Ecommerce\Product\CouldNotFindProductError;
use Ecommerce\Product\Product;
use Ecommerce\Product\ProductHasNotEnoughStockError;
use Ecommerce\Product\Provider as ProductProvider;
use Exception;
use Log\Log;

class Adder
{
	private CartAdder $cartAdder;

	private CartProvider $cartProvider;

	private ProductProvider $productProvider;

	private CartItemEntitySaver $cartItemEntitySaver;

	public function __construct(
		CartAdder $cartAdder,
		CartProvider $cartProvider,
		ProductProvider $productProvider,
		CartItemEntitySaver $cartItemEntitySaver
	)
	{
		$this->cartAdder           = $cartAdder;
		$this->cartProvider        = $cartProvider;
		$this->productProvider     = $productProvider;
		$this->cartItemEntitySaver = $cartItemEntitySaver;
	}

	public function add(AddData $addData): AddResult
	{
		$result = new AddResult();
		$result->setSuccess(false);

		$cart = $addData->getCart();

		if (!$cart)
		{
			$cart = $this->cartAdder->add();
		}

		try
		{
			$product = $this->productProvider->byId(
				$addData->getProductId()
			);

			if (!$product)
			{
				$result->addError(CouldNotFindProductError::create());

				return $result;
			}

			$amount = $addData->getAmount();

			if (!$product->hasEnoughStock($amount))
			{
				$result->addError(ProductHasNotEnoughStockError::create());

				return $result;
			}

			$itemEntity = $this->findOrCreateItemEntity($cart, $product);
			$itemEntity->setQuantity($amount);

			$this->cartItemEntitySaver->save($itemEntity);

			$result->setSuccess(true);
			$result->setCart(
				$this->cartProvider->byId($cart->getId())
			);
		}
		catch (Exception $ex)
		{
			Log::error($ex);
		}

		return $result;
	}

	private function findOrCreateItemEntity(Cart $cart, Product $product): ItemEntity
	{
		foreach ($cart->getItems() as $cartItem)
		{
			if (
				$cartItem
					->getProduct()
					->equals($product)
			)
			{
				return $cartItem->getEntity();
			}
		}

		$itemEntity = new ItemEntity();
		$itemEntity->setCart($cart->getEntity());
		$itemEntity->setProduct($product->getEntity());

		$cart
			->getEntity()
			->getItems()
			->add($itemEntity);

		return $itemEntity;
	}
}