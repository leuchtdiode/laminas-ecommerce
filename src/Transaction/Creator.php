<?php
namespace Ecommerce\Transaction;

use Ecommerce\Address\Creator as AddressCreator;
use Ecommerce\Common\EntityDtoCreator;
use Ecommerce\Common\Price;
use Ecommerce\Common\PriceCreator;
use Ecommerce\Common\UrlProvider;
use Ecommerce\Customer\Creator as CustomerCreator;
use Ecommerce\Db\Transaction\Entity;
use Ecommerce\Db\Transaction\Item\Entity as TransactionItemEntity;
use Ecommerce\Payment\MethodProvider as PaymentMethodProvider;
use Ecommerce\Transaction\Invoice\SecurityHashHandler;
use Ecommerce\Transaction\Item\Creator as TransactionItemCreator;
use Ecommerce\Transaction\Item\Item;
use Exception;

class Creator implements EntityDtoCreator
{
	const ONE_HOUR_IN_SECONDS = 3600;

	/**
	 * @var StatusProvider
	 */
	private $statusProvider;

	/**
	 * @var PostPaymentStatusProvider
	 */
	private $postPaymentStatusProvider;

	/**
	 * @var PaymentMethodProvider
	 */
	private $paymentMethodProvider;

	/**
	 * @var UrlProvider
	 */
	private $urlProvider;

	/**
	 * @var SecurityHashHandler
	 */
	private $securityHashHandler;

	/**
	 * @var PriceCreator
	 */
	private $priceCreator;

	/**
	 * @var TransactionItemCreator
	 */
	private $transactionItemCreator;

	/**
	 * @var AddressCreator
	 */
	private $addressCreator;

	/**
	 * @var CustomerCreator
	 */
	private $customerCreator;

	/**
	 * @param StatusProvider $statusProvider
	 * @param PostPaymentStatusProvider $postPaymentStatusProvider
	 * @param PaymentMethodProvider $paymentMethodProvider
	 * @param UrlProvider $urlProvider
	 * @param SecurityHashHandler $securityHashHandler
	 * @param PriceCreator $priceCreator
	 */
	public function __construct(
		StatusProvider $statusProvider,
		PostPaymentStatusProvider $postPaymentStatusProvider,
		PaymentMethodProvider $paymentMethodProvider,
		UrlProvider $urlProvider,
		SecurityHashHandler $securityHashHandler,
		PriceCreator $priceCreator
	)
	{
		$this->statusProvider            = $statusProvider;
		$this->postPaymentStatusProvider = $postPaymentStatusProvider;
		$this->paymentMethodProvider     = $paymentMethodProvider;
		$this->urlProvider               = $urlProvider;
		$this->securityHashHandler       = $securityHashHandler;
		$this->priceCreator              = $priceCreator;
	}

	/**
	 * @param TransactionItemCreator $transactionItemCreator
	 */
	public function setTransactionItemCreator(TransactionItemCreator $transactionItemCreator): void
	{
		$this->transactionItemCreator = $transactionItemCreator;
	}

	/**
	 * @param AddressCreator $addressCreator
	 */
	public function setAddressCreator(AddressCreator $addressCreator): void
	{
		$this->addressCreator = $addressCreator;
	}

	/**
	 * @param CustomerCreator $customerCreator
	 */
	public function setCustomerCreator(CustomerCreator $customerCreator): void
	{
		$this->customerCreator = $customerCreator;
	}

	/**
	 * @param Entity $entity
	 * @return Transaction
	 * @throws Exception
	 */
	public function byEntity($entity)
	{
		$items = array_map(
			function (TransactionItemEntity $entity)
			{
				return $this->transactionItemCreator->byEntity($entity);
			},
			$entity
				->getItems()
				->toArray()
		);

		$status = $this->statusProvider->byId($entity->getStatus());

		return new Transaction(
			$entity,
			$this->customerCreator->byEntity($entity->getCustomer()),
			$status,
			$this->paymentMethodProvider->byId($entity->getPaymentMethod()),
			$items,
			$this->addressCreator->byEntity($entity->getBillingAddress()),
			$this->addressCreator->byEntity($entity->getShippingAddress()),
			$this->getTotalPrice($items, $entity->getShippingCost()),
			$this->getTaxAmount($items),
			$status->is(Status::SUCCESS)
				? $this->getInvoiceUrl($entity)
				: null,
			($shippingCost = $entity->getShippingCost())
				? $this->priceCreator->fromCents($shippingCost, 0)
				: null,
			($postPaymentStatus = $entity->getPostPaymentStatus())
				? $this->postPaymentStatusProvider->byId($postPaymentStatus)
				: null
		);
	}

	/**
	 * @param Entity $entity
	 * @return string
	 * @throws Exception
	 */
	private function getInvoiceUrl(Entity $entity)
	{
		return $this->urlProvider->get(
				'ecommerce/transaction/single-item/invoice/pdf',
				[
					'transactionId'   => $entity
						->getId()
						->toString(),
					'referenceNumber' => $entity->getReferenceNumber(),
				]
			) . '?sec=' . $this->securityHashHandler->get(self::ONE_HOUR_IN_SECONDS);
	}

	/**
	 * @param Item[] $items
	 * @param int|null $shippingCost
	 * @return Price
	 */
	private function getTotalPrice(array $items, ?int $shippingCost)
	{
		$cents = 0;

		foreach ($items as $item)
		{
			$cents += (int)$item
				->getTotalPrice()
				->getGross();
		}

		if ($shippingCost)
		{
			$cents += $shippingCost;
		}

		return Price::fromCents($cents, 0);
	}

	/**
	 * @param Item[] $items
	 * @return Price
	 */
	private function getTaxAmount(array $items)
	{
		$taxAmountCents = 0;

		foreach ($items as $item)
		{
			$taxAmountCents += (int)$item
				->getTotalPrice()
				->getTaxAmount();
		}

		return Price::fromCents($taxAmountCents, 0);
	}
}