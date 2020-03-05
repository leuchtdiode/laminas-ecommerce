<?php
namespace Ecommerce\Customer\Auth;

use Ecommerce\Customer\Customer;
use Ecommerce\Mail\Sender;
use Mail\Mail\Recipient;

class ForgotPasswordMailSender extends Sender
{
	/**
	 * @var Customer
	 */
	private $customer;

	/**
	 * @var string
	 */
	private $hash;

	/**
	 * @param Customer $customer
	 * @param string $hash
	 * @return bool
	 */
	public function send(Customer $customer, string $hash)
	{
		$this->customer = $customer;
		$this->hash     = $hash;

		return $this->addToQueue();
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
		return $this->getEcommerceMailConfig()['customer']['forgotPassword']['template'];
	}

	/**
	 * @return string
	 */
	protected function getSubject()
	{
		return $this->getEcommerceMailConfig()['customer']['forgotPassword']['subject'];
	}

	/**
	 * @return ForgotPasswordMailPlaceholderValues
	 */
	protected function getPlaceholderValues()
	{
		return ForgotPasswordMailPlaceholderValues::create()
			->setCustomer($this->customer)
			->setHash($this->hash);
	}
}