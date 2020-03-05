<?php
namespace Ecommerce\Common;

use Ecommerce\Address\Creator as AddressCreator;
use Ecommerce\Cart\Creator as CartCreator;
use Ecommerce\Cart\Item\Creator as CartItemCreator;
use Ecommerce\Customer\Creator as CustomerCreator;
use Ecommerce\Product\Attribute\Creator as ProductAttributeCreator;
use Ecommerce\Product\Attribute\Value\Creator as ProductAttributeValueCreator;
use Ecommerce\Product\Creator as ProductCreator;
use Ecommerce\Product\Image\Creator as ProductImageCreator;
use Ecommerce\Transaction\Creator as TransactionCreator;
use Ecommerce\Transaction\Item\Creator as TransactionItemCreator;

class DtoCreatorProvider
{
	/**
	 * @var CustomerCreator
	 */
	private $customerCreator;

	/**
	 * @var AddressCreator
	 */
	private $addressCreator;

	/**
	 * @var ProductCreator
	 */
	private $productCreator;

	/**
	 * @var ProductAttributeCreator
	 */
	private $productAttributeCreator;

	/**
	 * @var ProductAttributeValueCreator
	 */
	private $productAttributeValueCreator;

	/**
	 * @var ProductImageCreator
	 */
	private $productImageCreator;

	/**
	 * @var TransactionCreator
	 */
	private $transactionCreator;

	/**
	 * @var TransactionItemCreator
	 */
	private $transactionItemCreator;

	/**
	 * @var CartCreator
	 */
	private $cartCreator;

	/**
	 * @var CartItemCreator
	 */
	private $cartItemCreator;

	/**
	 * @param CustomerCreator $customerCreator
	 * @param AddressCreator $addressCreator
	 * @param ProductCreator $productCreator
	 * @param ProductAttributeCreator $productAttributeCreator
	 * @param ProductAttributeValueCreator $productAttributeValueCreator
	 * @param ProductImageCreator $productImageCreator
	 * @param TransactionCreator $transactionCreator
	 * @param TransactionItemCreator $transactionItemCreator
	 * @param CartCreator $cartCreator
	 * @param CartItemCreator $cartItemCreator
	 */
	public function __construct(
		CustomerCreator $customerCreator,
		AddressCreator $addressCreator,
		ProductCreator $productCreator,
		ProductAttributeCreator $productAttributeCreator,
		ProductAttributeValueCreator $productAttributeValueCreator,
		ProductImageCreator $productImageCreator,
		TransactionCreator $transactionCreator,
		TransactionItemCreator $transactionItemCreator,
		CartCreator $cartCreator,
		CartItemCreator $cartItemCreator
	)
	{
		$this->customerCreator              = $customerCreator;
		$this->addressCreator               = $addressCreator;
		$this->productCreator               = $productCreator;
		$this->productAttributeCreator      = $productAttributeCreator;
		$this->productAttributeValueCreator = $productAttributeValueCreator;
		$this->productImageCreator          = $productImageCreator;
		$this->transactionCreator           = $transactionCreator;
		$this->transactionItemCreator       = $transactionItemCreator;
		$this->cartCreator                  = $cartCreator;
		$this->cartItemCreator              = $cartItemCreator;

		$this->handleDependencies();
	}

	/**
	 *
	 */
	private function handleDependencies()
	{
		$this->productAttributeValueCreator->setProductAttributeCreator($this->productAttributeCreator);
		$this->productCreator->setProductAttributeValueCreator($this->productAttributeValueCreator);
		$this->productCreator->setProductImageCreator($this->productImageCreator);
		$this->transactionCreator->setTransactionItemCreator($this->transactionItemCreator);
		$this->transactionCreator->setAddressCreator($this->addressCreator);
		$this->transactionCreator->setCustomerCreator($this->customerCreator);
		$this->transactionItemCreator->setProductCreator($this->productCreator);
		$this->cartCreator->setCartItemCreator($this->cartItemCreator);
		$this->cartItemCreator->setProductCreator($this->productCreator);
	}

	/**
	 * @return CustomerCreator
	 */
	public function getCustomerCreator(): CustomerCreator
	{
		return $this->customerCreator;
	}

	/**
	 * @return AddressCreator
	 */
	public function getAddressCreator(): AddressCreator
	{
		return $this->addressCreator;
	}

	/**
	 * @return ProductCreator
	 */
	public function getProductCreator(): ProductCreator
	{
		return $this->productCreator;
	}

	/**
	 * @return ProductAttributeCreator
	 */
	public function getProductAttributeCreator(): ProductAttributeCreator
	{
		return $this->productAttributeCreator;
	}

	/**
	 * @return ProductAttributeValueCreator
	 */
	public function getProductAttributeValueCreator(): ProductAttributeValueCreator
	{
		return $this->productAttributeValueCreator;
	}

	/**
	 * @return ProductImageCreator
	 */
	public function getProductImageCreator(): ProductImageCreator
	{
		return $this->productImageCreator;
	}

	/**
	 * @return TransactionCreator
	 */
	public function getTransactionCreator(): TransactionCreator
	{
		return $this->transactionCreator;
	}

	/**
	 * @return TransactionItemCreator
	 */
	public function getTransactionItemCreator(): TransactionItemCreator
	{
		return $this->transactionItemCreator;
	}

	/**
	 * @return CartCreator
	 */
	public function getCartCreator(): CartCreator
	{
		return $this->cartCreator;
	}

	/**
	 * @return CartItemCreator
	 */
	public function getCartItemCreator(): CartItemCreator
	{
		return $this->cartItemCreator;
	}
}