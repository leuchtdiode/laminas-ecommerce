<?php
namespace Ecommerce\Transaction;

use Ecommerce\Address\Creator as AddressCreator;
use Ecommerce\Common\EntityDtoCreator;
use Ecommerce\Common\Price;
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
	 * @param PaymentMethodProvider $paymentMethodProvider
	 * @param UrlProvider $urlProvider
	 * @param SecurityHashHandler $securityHashHandler
	 */
	public function __construct(
		StatusProvider $statusProvider,
		PaymentMethodProvider $paymentMethodProvider,
		UrlProvider $urlProvider,
		SecurityHashHandler $securityHashHandler
	)
	{
		$this->statusProvider = $statusProvider;
		$this->paymentMethodProvider = $paymentMethodProvider;
		$this->urlProvider = $urlProvider;
		$this->securityHashHandler = $securityHashHandler;
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
			$entity->getItems()->toArray()
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
			$this->getTotalPrice($items),
			$status->is(Status::SUCCESS)
				? $this->getInvoiceUrl($entity)
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
			'ecommerce/transaction/single-item/invoice',
			[
				'transactionId'   => $entity->getId()->toString(),
				'referenceNumber' => $entity->getReferenceNumber(),
			]
		) . '?sec=' . $this->securityHashHandler->get(self::ONE_HOUR_IN_SECONDS);
	}

	/**
	 * @param Item[] $items
	 * @return Price
	 */
	private function getTotalPrice(array $items)
	{
		$cents = 0;

		foreach ($items as $item)
		{
			$cents += (int)$item->getTotalPrice()->getGross();
		}

		return Price::fromCents($cents, 0);
	}
}