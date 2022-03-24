<?php
namespace Ecommerce\Customer\Auth;

use Ecommerce\Customer\Customer;
use Ecommerce\Mail\Sender;
use Mail\Mail\Recipient;

class ForgotPasswordMailSender extends Sender
{
	private Customer $customer;

	private string $hash;

	public function send(Customer $customer, string $hash): bool
	{
		$this->customer = $customer;
		$this->hash     = $hash;

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
		return $this->getEcommerceMailConfig()['customer']['forgotPassword']['template'];
	}

	protected function getSubject(): string
	{
		return $this->getEcommerceMailConfig()['customer']['forgotPassword']['subject'];
	}

	protected function getPlaceholderValues(): ForgotPasswordMailPlaceholderValues
	{
		return ForgotPasswordMailPlaceholderValues::create()
			->setCustomer($this->customer)
			->setHash($this->hash);
	}
}