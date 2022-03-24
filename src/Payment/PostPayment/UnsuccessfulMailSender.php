<?php
namespace Ecommerce\Payment\PostPayment;

use Ecommerce\Customer\Customer;
use Ecommerce\Mail\Sender;
use Ecommerce\Transaction\Transaction;
use Log\Log;
use Mail\Mail\Recipient;

class UnsuccessfulMailSender extends Sender
{
	private Transaction $transaction;

	private Customer $customer;

	public function send(Transaction $transaction): bool
	{
		Log::debug('Sending unsuccessful payment mail for ' . $transaction->getId()->toString());

		$this->transaction = $transaction;
		$this->customer    = $transaction->getCustomer();

		return $this->addToQueue();
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
		return $this->getEcommerceMailConfig()['payment']['unsuccessful']['template'];
	}

	protected function getSubject(): string
	{
		return $this->getEcommerceMailConfig()['payment']['unsuccessful']['subject'];
	}

	protected function getPlaceholderValues(): UnsuccessfulMailPlaceholderValues
	{
		return UnsuccessfulMailPlaceholderValues::create()
			->setTransaction($this->transaction)
			->setCustomer($this->customer);
	}
}