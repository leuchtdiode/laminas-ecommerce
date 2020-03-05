<?php
namespace Ecommerce\Cart\Item;

use Ecommerce\Cart\Adder as CartAdder;
use Ecommerce\Cart\Cart;
use Ecommerce\Cart\Provider as CartProvider;
use Ecommerce\Db\Cart\Item\Entity as ItemEntity;
use Ecommerce\Db\Cart\Saver as CartEntitySaver;
use Ecommerce\Db\Cart\Item\Saver as CartItemEntitySaver;
use Ecommerce\Product\CouldNotFindProductError;
use Ecommerce\Product\Product;
use Ecommerce\Product\ProductHasNotEnoughStockError;
use Ecommerce\Product\Provider as ProductProvider;
use Exception;
use Log\Log;

class Adder
{
	/**
	 * @var CartAdder
	 */
	private $cartAdder;

	/**
	 * @var CartProvider
	 */
	private $cartProvider;

	/**
	 * @var ProductProvider
	 */
	private $productProvider;

	/**
	 * @var CartEntitySaver
	 */
	private $cartEntitySaver;

	/**
	 * @var CartItemEntitySaver
	 */
	private $cartItemEntitySaver;

	/**
	 * @var AddData
	 */
	private $addData;

	/**
	 * @param CartAdder $cartAdder
	 * @param CartProvider $cartProvider
	 * @param ProductProvider $productProvider
	 * @param CartEntitySaver $cartEntitySaver
	 * @param CartItemEntitySaver $cartItemEntitySaver
	 */
	public function __construct(
		CartAdder $cartAdder,
		CartProvider $cartProvider,
		ProductProvider $productProvider,
		CartEntitySaver $cartEntitySaver,
		CartItemEntitySaver $cartItemEntitySaver
	)
	{
		$this->cartAdder           = $cartAdder;
		$this->cartProvider        = $cartProvider;
		$this->productProvider     = $productProvider;
		$this->cartEntitySaver     = $cartEntitySaver;
		$this->cartItemEntitySaver = $cartItemEntitySaver;
	}

	/**
	 * @param AddData $addData
	 * @return AddResult
	 */
	public function add(AddData $addData)
	{
		$this->addData = $addData;

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

	/**
	 * @param Cart $cart
	 * @param Product $product
	 * @return ItemEntity
	 * @throws Exception
	 */
	private function findOrCreateItemEntity(Cart $cart, Product $product)
	{
		foreach ($cart->getItems() as $cartItem)
		{
			if ($cartItem->getProduct()->equals($product))
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