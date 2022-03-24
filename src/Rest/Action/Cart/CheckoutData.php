<?php
namespace Ecommerce\Rest\Action\Cart;

use Common\RequestData\Data;
use Common\RequestData\PropertyDefinition\Text;
use Common\RequestData\PropertyDefinition\Uuid;
use Ecommerce\Payment\MethodValidator;

class CheckoutData extends Data
{
	const PAYMENT_METHOD      = 'paymentMethod';
	const BILLING_ADDRESS_ID  = 'billingAddressId';
	const SHIPPING_ADDRESS_ID = 'shippingAddressId';

	public function getDefinitions(): array
	{
		return [
			Text::create()
				->setName(self::PAYMENT_METHOD)
				->addValidator($this->container->get(MethodValidator::class))
				->setRequired(true),
			Uuid::create()
				->setName(self::BILLING_ADDRESS_ID)
				->setRequired(true),
			Uuid::create()
				->setName(self::SHIPPING_ADDRESS_ID)
				->setRequired(true),
		];
	}
}