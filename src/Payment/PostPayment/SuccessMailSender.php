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
	private InvoiceProvider $invoiceProvider;

	private Transaction $transaction;

	private Customer $customer;

	public function __construct(array $config, Queue $mailQueue, InvoiceProvider $invoiceProvider)
	{
		parent::__construct($config, $mailQueue);

		$this->invoiceProvider = $invoiceProvider;
	}

	public function send(Transaction $transaction): bool
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
	protected function getAttachments(): array
	{
		$invoice = $this->invoiceProvider->get($this->transaction);

		return [
			Attachment::create()
				->setFileName($invoice->getFileName())
				->setMimeType($invoice->getMimeType())
				->setContent($invoice->getContent())
		];
	}

	protected function getRecipient(): Recipient
	{
		return Recipient::create(
			$this->customer->getEmail(),
			$this->customer->getName()
		);
	}

	protected function getContentTemplate(): string
	{
		return $this->getEcommerceMailConfig()['payment']['successful']['template'];
	}

	protected function getSubject(): string
	{
		return $this->getEcommerceMailConfig()['payment']['successful']['subject'];
	}

	protected function getPlaceholderValues(): SuccessMailPlaceholderValues
	{
		return SuccessMailPlaceholderValues::create()
			->setTransaction($this->transaction)
			->setCustomer($this->customer);
	}
}
