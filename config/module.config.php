<?php
namespace Ecommerce;

use Common\Router\HttpRouteCreator;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use DoctrineExtensions\Query\Mysql\Year;
use Ecommerce\Payment\Method;
use Ecommerce\Payment\MethodHandler\AmazonPay\MethodHandler as AmazonPayMethodHandler;
use Ecommerce\Payment\MethodHandler\PayPal\MethodHandler as PayPalMethodHandler;
use Ecommerce\Payment\MethodHandler\PayPal\PendingCheckProcessor;
use Ecommerce\Payment\MethodHandler\PrePayment\MethodHandler as PrePaymentMethodHandler;
use Ecommerce\Payment\MethodHandler\Wirecard\MethodHandler as WirecardMethodHandler;
use Ecommerce\Product\Price\DefaultProvider as DefaultPriceProvider;
use Ecommerce\Rest\Action\Plugin\Auth;
use Ecommerce\Rest\Action\Plugin\AuthFactory;
use Ecommerce\Tax\AustriaMossRateProvider;
use Ecommerce\Transaction\Invoice\Number\DefaultGenerator as DefaultInvoiceNumberGenerator;
use Ramsey\Uuid\Doctrine\UuidType;

return [

	'ecommerce' => [
		'taxRate' => [
			'provider' => AustriaMossRateProvider::class,
		],
		'price'   => [
			'provider' => DefaultPriceProvider::class,
		],
		'invoice' => [
			'number' => [
				'generator' => DefaultInvoiceNumberGenerator::class,
				'default'   => [
					'template'                => '%year2Digits%%consecutiveNumber%',
					'consecutiveNumberLength' => 5,
				],
			],
			'bulk'   => [
				'ghostScriptBin' => '/usr/bin/gs',
			],
		],
		'payment' => [
			'method' => [
				Method::PAY_PAL     => [
					'handler' => PayPalMethodHandler::class,
					'options' => [
						// ... local config
					],
				],
				Method::AMAZON_PAY  => [
					'handler' => AmazonPayMethodHandler::class,
					'options' => [
						// ... local config
					],
				],
				Method::PRE_PAYMENT => [
					'handler' => PrePaymentMethodHandler::class,
					'options' => [
						// ... local config
					],
				],
				Method::WIRECARD    => [
					'handler' => WirecardMethodHandler::class,
					'options' => [
						'hostTest' => 'https://wpp-test.wirecard.com',
						'hostLive' => 'https://wpp.wirecard.com',
						// ... local config
						// -> sandbox (true|false)
						// -> merchantAccountId (UUID)
						// -> username
						// -> password
						// -> secretKey
					],
				],
			],
		],
	],

	'async-queue' => [
		'processors' => [
			PendingCheckProcessor::ID => PendingCheckProcessor::class,
		],
	],

	'router' => [
		'routes' => [
			'ecommerce' => HttpRouteCreator::create()
				->setRoute('/ecommerce')
				->setMayTerminate(false)
				->setChildRoutes(
					[
						'customer'    => include 'routes/customer.php',
						'product'     => include 'routes/product.php',
						'cart'        => include 'routes/cart.php',
						'payment'     => include 'routes/payment.php',
						'transaction' => include 'routes/transaction.php',
						'invoice'     => include 'routes/invoice.php',
					]
				)
				->getConfig(),
		],
	],

	'doctrine' => [
		'configuration' => [
			'orm_default' => [
				'types'            => [
					UuidType::NAME => UuidType::class,
				],
				'string_functions' => [
					'YEAR' => Year::class,
				],
			],
		],
		'driver'        => [
			'ecommerce_entities' => [
				'class' => AnnotationDriver::class,
				'cache' => 'array',
				'paths' => [ __DIR__ . '/../src/Db' ],
			],
			'orm_default'        => [
				'drivers' => [
					'Ecommerce' => 'ecommerce_entities',
				],
			],
		],
	],

	'translator' => [
		'translation_file_patterns' => [
			[
				'type'     => 'gettext',
				'base_dir' => __DIR__ . '/../language',
				'pattern'  => '%s.mo',
			],
		],
	],

	'service_manager' => [
		'abstract_factories' => [
			DefaultFactory::class,
		],
	],

	'controllers' => [
		'abstract_factories' => [
			DefaultFactory::class,
		],
	],

	'controller_plugins' => [
		'factories' => [
			Auth::class => AuthFactory::class,
		],
		'aliases'   => [
			'auth' => Auth::class,
		],
	],
];