<?php
namespace Ecommerce\Payment\MethodHandler\PayPal;

use Ecommerce\Payment\Method;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class Api extends ApiContext
{
	const SANDBOX = 'sandbox';
	const LIVE    = 'live';
	
	public function __construct(array $config)
	{
		$payPalConfig = $config['ecommerce']['payment']['method'][Method::PAY_PAL]['options'];

		parent::__construct(
			new OAuthTokenCredential(
				$payPalConfig['clientId'],
				$payPalConfig['clientSecret']
			)
		);

		$this->setConfig(
			[
				'http.ConnectionTimeOut' => $payPalConfig['http']['timeout'],
				'http.Retry'             => $payPalConfig['http']['retry'],
				'mode'                   => ($payPalConfig['sandbox'] ?? false) ? self::SANDBOX : self::LIVE,
				'log.LogEnabled'         => $payPalConfig['log']['enabled'],
				'log.FileName'           => $payPalConfig['log']['file'],
				'log.LogLevel'           => $payPalConfig['log']['level']
			]
		);
	}
}