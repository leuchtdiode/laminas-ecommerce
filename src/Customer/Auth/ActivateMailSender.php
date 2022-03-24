<?php
namespace Ecommerce\Customer\Auth;

use Ecommerce\Customer\Customer;
use Ecommerce\Mail\Sender;
use Mail\Mail\Recipient;

class ActivateMailSender extends Sender
{
	private Customer $customer;

	public function send(Customer $customer): bool
	{
		$this->customer = $customer;

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
		return $this->getEcommerceMailConfig()['customer']['activate']['template'];
	}

	protected function getSubject(): string
	{
		return $this->getEcommerceMailConfig()['customer']['activate']['subject'];
	}

	protected function getPlaceholderValues(): ActivateMailPlaceholderValues
	{
		return ActivateMailPlaceholderValues::create()
			->setCustomer($this->customer);
	}
}