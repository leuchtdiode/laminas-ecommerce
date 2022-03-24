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
	private CustomerCreator $customerCreator;

	private AddressCreator $addressCreator;

	private ProductCreator $productCreator;

	private ProductAttributeCreator $productAttributeCreator;

	private ProductAttributeValueCreator $productAttributeValueCreator;

	private ProductImageCreator $productImageCreator;

	private TransactionCreator $transactionCreator;

	private TransactionItemCreator $transactionItemCreator;

	private CartCreator $cartCreator;

	private CartItemCreator $cartItemCreator;

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

	public function getCustomerCreator(): CustomerCreator
	{
		return $this->customerCreator;
	}

	public function getAddressCreator(): AddressCreator
	{
		return $this->addressCreator;
	}

	public function getProductCreator(): ProductCreator
	{
		return $this->productCreator;
	}

	public function getProductAttributeCreator(): ProductAttributeCreator
	{
		return $this->productAttributeCreator;
	}

	public function getProductAttributeValueCreator(): ProductAttributeValueCreator
	{
		return $this->productAttributeValueCreator;
	}

	public function getProductImageCreator(): ProductImageCreator
	{
		return $this->productImageCreator;
	}

	public function getTransactionCreator(): TransactionCreator
	{
		return $this->transactionCreator;
	}

	public function getTransactionItemCreator(): TransactionItemCreator
	{
		return $this->transactionItemCreator;
	}

	public function getCartCreator(): CartCreator
	{
		return $this->cartCreator;
	}

	public function getCartItemCreator(): CartItemCreator
	{
		return $this->cartItemCreator;
	}
}