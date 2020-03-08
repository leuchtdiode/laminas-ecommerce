<?php
namespace Ecommerce\Common;

class Event
{
	const ID                       = 'ecommerce';
	const CART_CHECKOUT_SUCCESSFUL = 'ecommerce.cart.checkout.successful';
	const PAYMENT_SUCCESSFUL       = 'ecommerce.payment.successful';
	const PAYMENT_UNSUCCESSFUL     = 'ecommerce.payment.unsuccessful';
}