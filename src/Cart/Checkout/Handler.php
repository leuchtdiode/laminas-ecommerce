<?php

namespace Ecommerce\Cart\Checkout;

use Ecommerce\Address\Address;
use Ecommerce\Cart\Cart;
use Ecommerce\Cart\InvalidCartError;
use Ecommerce\Common\DtoCreatorProvider;
use Ecommerce\Common\Event;
use Ecommerce\Common\EventManagerTrait;
use Ecommerce\Customer\Customer;
use Ecommerce\Db\Transaction\Entity as TransactionEntity;
use Ecommerce\Db\Transaction\Item\Entity as TransactionItemEntity;
use Ecommerce\Db\Transaction\Saver as TransactionEntitySaver;
use Ecommerce\Payment\MethodHandler\InitData;
use Ecommerce\Payment\MethodHandler\Provider as MethodHandlerProvider;
use Ecommerce\Shipping\CostProvider;
use Ecommerce\Shipping\GetData;
use Ecommerce\Transaction\ReferenceNumberProvider;
use Ecommerce\Transaction\Status;
use Ecommerce\Transaction\Transaction;
use Exception;
use Laminas\EventManager\EventManager;
use Laminas\EventManager\EventManagerAwareInterface;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\SharedEventManager;
use Log\Log;
use Psr\Container\ContainerInterface;
use RuntimeException;

class Handler implements EventManagerAwareInterface
{
	use EventManagerTrait;

	/**
	 * @var array
	 */
	private $config;

	/**
	 * @var ContainerInterface
	 */
	private $container;

	/**
	 * @var MethodHandlerProvider
	 */
	private $methodHandlerProvider;

	/**
	 * @var TransactionEntitySaver
	 */
	private $transactionEntitySaver;

	/**
	 * @var DtoCreatorProvider
	 */
	private $dtoCreatorProvider;

	/**
	 * @var ReferenceNumberProvider
	 */
	private $referenceNumberProvider;

	/**
	 * @var CheckoutData
	 */
	private $data;

	/**
	 * @var Transaction
	 */
	private $transaction;

	/**
	 * @param array $config
	 * @param ContainerInterface $container
	 * @param MethodHandlerProvider $methodHandlerProvider
	 * @param TransactionEntitySaver $transactionEntitySaver
	 * @param DtoCreatorProvider $dtoCreatorProvider
	 * @param ReferenceNumberProvider $referenceNumberProvider
	 */
	public function __construct(
		array $config,
		ContainerInterface $container,
		MethodHandlerProvider $methodHandlerProvider,
		TransactionEntitySaver $transactionEntitySaver,
		DtoCreatorProvider $dtoCreatorProvider,
		ReferenceNumberProvider $referenceNumberProvider
	)
	{
		$this->config                  = $config;
		$this->container               = $container;
		$this->methodHandlerProvider   = $methodHandlerProvider;
		$this->transactionEntitySaver  = $transactionEntitySaver;
		$this->dtoCreatorProvider      = $dtoCreatorProvider;
		$this->referenceNumberProvider = $referenceNumberProvider;
	}

	/**
	 * @param CheckoutData $data
	 * @return CheckoutResult
	 * @throws RuntimeException
	 */
	public function checkout(CheckoutData $data)
	{
		$this->data = $data;

		$result = new CheckoutResult();
		$result->setSuccess(false);

		$methodHandler = $this->methodHandlerProvider->getHandler(
			$data->getPaymentMethod()
		);

		$cart = $data->getCart();

		if (!$cart->isValid())
		{
			$result->addError(InvalidCartError::create());

			return $result;
		}

		if (!$this->createTransaction())
		{
			return $result;
		}

		$initResult = $methodHandler->init(
			InitData::create()
				->setTransaction($this->transaction)
		);

		if (!$initResult->isSuccess())
		{
			$result->setSuccess(false);
			$result->setErrors($initResult->getErrors());

			return $result;
		}

		$this
			->getEventManager()
			->trigger(Event::CART_CHECKOUT_SUCCESSFUL, $this);

		$result->setSuccess(true);
		$result->setRedirectUrl($initResult->getRedirectUrl());

		return $result;
	}

	/**
	 * @return bool
	 */
	private function createTransaction()
	{
		$cart = $this->data->getCart();

		try
		{
			$transactionEntity = new TransactionEntity();
			$transactionEntity->setReferenceNumber(
				$this->referenceNumberProvider->create()
			);
			$transactionEntity->setCustomer(
				$this->data
					->getCustomer()
					->getEntity()
			);
			$transactionEntity->setBillingAddress(
				$this->data
					->getBillingAddress()
					->getEntity()
			);
			$transactionEntity->setShippingAddress(
				$this->data
					->getShippingAddress()
					->getEntity()
			);
			$transactionEntity->setPaymentMethod(
				$this->data->getPaymentMethod()
					->getId()
			);
			$transactionEntity->setShippingCost(
				$this->getShippingCost(
					$cart,
					$this->data->getCustomer(),
					$this->data->getShippingAddress()
				)
			);
			$transactionEntity->setStatus(Status::NEW);

			foreach ($cart->getItems() as $cartItem)
			{
				$product = $cartItem->getProduct();
				$price   = $product->getPrice();

				$transactionItemEntity = new TransactionItemEntity();
				$transactionItemEntity->setTransaction($transactionEntity);
				$transactionItemEntity->setAmount($cartItem->getQuantity());
				$transactionItemEntity->setProduct($product->getEntity());
				$transactionItemEntity->setPrice($price->getNet() * $cartItem->getQuantity());
				$transactionItemEntity->setTax($price->getTaxRate()); // TODO correct?

				$transactionEntity
					->getItems()
					->add($transactionItemEntity);
			}

			$this->transactionEntitySaver->save($transactionEntity);

			$this->transaction = $this->dtoCreatorProvider
				->getTransactionCreator()
				->byEntity($transactionEntity);

			return true;
		}
		catch (Exception $ex)
		{
			Log::error($ex);
		}

		return false;
	}

	/**
	 * @param Customer $customer
	 * @param Address $shippingAddress
	 * @return int|null
	 * @throws Exception
	 */
	private function getShippingCost(Cart $cart, Customer $customer, Address $shippingAddress)
	{
		$shippingProviderClass = $this->config['ecommerce']['shipping']['costProvider'] ?? null;

		if (!$shippingProviderClass)
		{
			return null;
		}

		$shippingCostProvider = $this->container->get($shippingProviderClass);

		if (!$shippingCostProvider || !$shippingCostProvider instanceof CostProvider)
		{
			throw new Exception('Could not get instance of ' . $shippingProviderClass);
		}

		return $shippingCostProvider->get(
			GetData::create()
				->setCart($cart)
				->setCustomer($customer)
				->setShippingAddress($shippingAddress)
		);
	}
}