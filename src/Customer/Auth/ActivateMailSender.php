<?php
namespace Ecommerce\Customer\Auth;

use Ecommerce\Customer\Customer;
use Ecommerce\Mail\Sender;
use Mail\Mail\Recipient;

class ActivateMailSender extends Sender
{
	/**
	 * @var Customer
	 */
	private $customer;

	/**
	 * @param Customer $customer
	 * @return bool
	 */
	public function send(Customer $customer)
	{
		$this->customer = $customer;

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
		return $this->getEcommerceMailConfig()['customer']['activate']['template'];
	}

	/**
	 * @return string
	 */
	protected function getSubject()
	{
		return $this->getEcommerceMailConfig()['customer']['activate']['subject'];
	}

	/**
	 * @return ActivateMailPlaceholderValues
	 */
	protected function getPlaceholderValues()
	{
		return ActivateMailPlaceholderValues::create()
			->setCustomer($this->customer);
	}
}