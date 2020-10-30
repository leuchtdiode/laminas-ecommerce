<?php
namespace Ecommerce\Payment;

class CallbackType
{
	const SUCCESS      = 'success';
	const CANCEL       = 'cancel';
	const ERROR        = 'error';
	const PRE_PAYMENT  = 'pre-payment';
	const CONFIRMATION = 'confirmation';
}