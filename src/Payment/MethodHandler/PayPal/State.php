<?php
namespace Ecommerce\Payment\MethodHandler\PayPal;

class State
{
	const APPROVED  = 'approved';
	const CANCELLED = 'cancelled';
	const FAILED    = 'failed';
	const EXPIRED   = 'expired';

	const SALE_PENDING   = 'pending';
	const SALE_DENIED    = 'denied';
	const SALE_COMPLETED = 'completed';
}