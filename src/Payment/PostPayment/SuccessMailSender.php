<?php
namespace Ecommerce\Payment\PostPayment;

use Ecommerce\Customer\Customer;
use Ecommerce\Mail\Sender;
use Ecommerce\Transaction\Invoice\Provider as InvoiceProvider;
use Ecommerce\Transaction\Transaction;
use Exception;
use Log\Log;
use Mail\Mail\Attachment;
use Mail\Mail\Recipient;
use Mail\Queue\Queue;

class SuccessMailSender extends Sender
{
	/**
	 * @var InvoiceProvider
	 */
	private $invoiceProvider;

	/**
	 * @var Transaction
	 */
	private $transaction;

	/**
	 * @var Customer
	 */
	private $customer;

	/**
	 * @param array $config
	 * @param Queue $mailQueue
	 * @param InvoiceProvider $invoiceProvider
	 */
	public function __construct(array $config, Queue $mailQueue, InvoiceProvider $invoiceProvider)
	{
		parent::__construct($config, $mailQueue);

		$this->invoiceProvider = $invoiceProvider;
	}

	/**
	 * @param Transaction $transaction
	 * @return bool
	 */
	public function send(Transaction $transaction)
	{
		Log::debug('Sending success payment mail for ' . $transaction->getId()->toString());

		$this->transaction = $transaction;
		$this->customer    = $transaction->getCustomer();

		return $this->addToQueue();
	}

	/**
	 * @return Attachment[]
	 * @throws Exception
	 */
	protected function getAttachments()
	{
		$invoice = $this->invoiceProvider->get($this->transaction);

		return [
			Attachment::create()
				->setFileName($invoice->getFileName())
				->setMimeType($invoice->getMimeType())
				->setContent($invoice->getContent())
		];
	}

	/**
	 * @return Recipient
	 */
	protected function getRecipient()
	{
		return Recipient::create(
			$this->customer->getEmail(),
			$this->customer->getName()
		);
	}

	/**
	 * @return string
	 */
	protected function getContentTemplate()
	{
		return $this->getEcommerceMailConfig()['payment']['successful']['template'];
	}

	/**
	 * @return string
	 */
	protected function getSubject()
	{
		return $this->getEcommerceMailConfig()['payment']['successful']['subject'];
	}

	/**
	 * @return SuccessMailPlaceholderValues
	 */
	protected function getPlaceholderValues()
	{
		return SuccessMailPlaceholderValues::create()
			->setTransaction($this->transaction)
			->setCustomer($this->customer);
	}
}
