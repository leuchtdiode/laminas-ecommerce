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
use Ecommerce\Product\Price\GetPriceData;
use Ecommerce\Product\Price\Provider as PriceProvider;
use Ecommerce\Shipping\CostProvider;
use Ecommerce\Shipping\GetData;
use Ecommerce\Tax\GetData as TaxGetData;
use Ecommerce\Tax\GetProvider as GetTaxRateProvider;
use Ecommerce\Transaction\Provider as TransactionProvider;
use Ecommerce\Transaction\ReferenceNumberProvider;
use Ecommerce\Transaction\Status;
use Ecommerce\Transaction\Transaction;
use Exception;
use Laminas\EventManager\EventManagerAwareInterface;
use Log\Log;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class Handler implements EventManagerAwareInterface
{
	use EventManagerTrait;

	private array $config;

	private ContainerInterface $container;

	private MethodHandlerProvider $methodHandlerProvider;

	private TransactionProvider $transactionProvider;

	private TransactionEntitySaver $transactionEntitySaver;

	private DtoCreatorProvider $dtoCreatorProvider;

	private ReferenceNumberProvider $referenceNumberProvider;

	private GetTaxRateProvider $getTaxRateProvider;

	private CheckoutData $data;

	private Transaction $transaction;

	public function __construct(
		array $config,
		ContainerInterface $container,
		MethodHandlerProvider $methodHandlerProvider,
		TransactionProvider $transactionProvider,
		TransactionEntitySaver $transactionEntitySaver,
		DtoCreatorProvider $dtoCreatorProvider,
		ReferenceNumberProvider $referenceNumberProvider,
		GetTaxRateProvider $getTaxRateProvider
	)
	{
		$this->config                  = $config;
		$this->container               = $container;
		$this->methodHandlerProvider   = $methodHandlerProvider;
		$this->transactionProvider     = $transactionProvider;
		$this->transactionEntitySaver  = $transactionEntitySaver;
		$this->dtoCreatorProvider      = $dtoCreatorProvider;
		$this->referenceNumberProvider = $referenceNumberProvider;
		$this->getTaxRateProvider      = $getTaxRateProvider;
	}

	/**
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 */
	public function checkout(CheckoutData $data): CheckoutResult
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
		$result->setTransaction(
			$this->transactionProvider->byId(
				$this->transaction->getId()
			)
		);
		$result->setRedirectUrl($initResult->getRedirectUrl());

		return $result;
	}

	/**
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 */
	private function createTransaction(): bool
	{
		$taxRateProvider = $this->getTaxRateProvider->get();

		$cart           = $this->data->getCart();
		$customer       = $this->data->getCustomer();
		$billingAddress = $this->data->getBillingAddress();

		try
		{
			$transactionEntity = new TransactionEntity();
			$transactionEntity->setReferenceNumber(
				$this->referenceNumberProvider->create()
			);
			$transactionEntity->setCustomer(
				$customer->getEntity()
			);
			$transactionEntity->setBillingAddress(
				$billingAddress->getEntity()
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

			if (($transactionCreatedDate = $this->data->getTransactionCreatedDate()))
			{
				$transactionEntity->setCreatedDate($transactionCreatedDate);
			}

			/**
			 * @var PriceProvider $priceProvider
			 */
			$priceProvider = $this->container->get(
				$this->config['ecommerce']['price']['provider']
			);

			foreach ($cart->getItems() as $cartItem)
			{
				$product = $cartItem->getProduct();

				$priceResult = $priceProvider->get(
					GetPriceData::create()
						->setProduct($product)
						->setQuantity($cartItem->getQuantity())
				);

				$price = $priceResult->getPrice();

				$transactionItemEntity = new TransactionItemEntity();
				$transactionItemEntity->setTransaction($transactionEntity);
				$transactionItemEntity->setAmount($cartItem->getQuantity());
				$transactionItemEntity->setProduct($product->getEntity());
				$transactionItemEntity->setPrice($price->getNet() * $cartItem->getQuantity());
				$transactionItemEntity->setTax(
					$taxRateProvider
						->get(
							TaxGetData::create()
								->setCountry($billingAddress->getCountry())
								->setBusiness($customer->hasCompany())
						)
						->getRate()
				);

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
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 * @throws Exception
	 */
	private function getShippingCost(Cart $cart, Customer $customer, Address $shippingAddress): ?int
	{
		$shippingProviderClass = $this->config['ecommerce']['shipping']['costProvider'] ?? null;

		if (!$shippingProviderClass)
		{
			return null;
		}

		$shippingCostProvider = $this->container->get($shippingProviderClass);

		if (!$shippingCostProvider instanceof CostProvider)
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