<?php
namespace Ecommerce\Cart\Checkout;

use Ecommerce\Cart\InvalidCartError;
use Ecommerce\Common\DtoCreatorProvider;
use Ecommerce\Db\Transaction\Entity as TransactionEntity;
use Ecommerce\Db\Transaction\Item\Entity as TransactionItemEntity;
use Ecommerce\Db\Transaction\Saver as TransactionEntitySaver;
use Ecommerce\Payment\MethodHandler\InitData;
use Ecommerce\Transaction\ReferenceNumberProvider;
use Ecommerce\Transaction\Status;
use Ecommerce\Transaction\Transaction;
use Exception;
use Log\Log;
use RuntimeException;
use Ecommerce\Payment\MethodHandler\Provider as MethodHandlerProvider;

class Handler
{
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
	 * @param MethodHandlerProvider $methodHandlerProvider
	 * @param TransactionEntitySaver $transactionEntitySaver
	 * @param DtoCreatorProvider $dtoCreatorProvider
	 * @param ReferenceNumberProvider $referenceNumberProvider
	 */
	public function __construct(
		MethodHandlerProvider $methodHandlerProvider,
		TransactionEntitySaver $transactionEntitySaver,
		DtoCreatorProvider $dtoCreatorProvider,
		ReferenceNumberProvider $referenceNumberProvider
	)
	{
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

		$result->setSuccess(true);
		$result->setRedirectUrl($initResult->getRedirectUrl());

		return $result;
	}

	/**
	 * @return bool
	 */
	private function createTransaction()
	{
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
				$this->data->getPaymentMethod()->getId()
			);
			$transactionEntity->setStatus(Status::NEW);

			foreach ($this->data->getCart()->getItems() as $cartItem)
			{
				$product = $cartItem->getProduct();

				$transactionItemEntity = new TransactionItemEntity();
				$transactionItemEntity->setTransaction($transactionEntity);
				$transactionItemEntity->setAmount($cartItem->getQuantity());
				$transactionItemEntity->setProduct($product->getEntity());
				$transactionItemEntity->setPrice($product->getPrice()->getNet() * $cartItem->getQuantity());
				$transactionItemEntity->setTax($product->getPrice()->getTaxRate()); // TODO correct?

				$transactionEntity->getItems()->add($transactionItemEntity);
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
}