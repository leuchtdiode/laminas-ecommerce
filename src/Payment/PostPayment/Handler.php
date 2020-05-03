<?php
namespace Ecommerce\Payment\PostPayment;

use Common\Db\FilterChain;
use Common\Db\OrderChain;
use Ecommerce\Common\Event;
use Ecommerce\Common\EventManagerTrait;
use Ecommerce\Db\Transaction\Filter\ConsecutiveSuccessNumberInYear as ConsecutiveSuccessNumberInYearFilter;
use Ecommerce\Db\Transaction\Filter\CreationYear;
use Ecommerce\Db\Transaction\Order\ConsecutiveSuccessNumberInYear;
use Ecommerce\Db\Transaction\Saver as TransactionEntitySaver;
use Ecommerce\Transaction\Invoice\DefaultGenerator as DefaultInvoiceGenerator;
use Ecommerce\Transaction\Invoice\GenerateData;
use Ecommerce\Transaction\Invoice\Number\GenerateData as InvoiceNumberGenerateData;
use Ecommerce\Transaction\Invoice\Number\Generator as InvoiceNumberGenerator;
use Ecommerce\Transaction\Provider as TransactionProvider;
use Ecommerce\Transaction\Transaction;
use Exception;
use Laminas\EventManager\EventManagerAwareInterface;
use Psr\Container\ContainerInterface;

class Handler implements EventManagerAwareInterface
{
	use EventManagerTrait;

	/**
	 * @var array
	 */
	private $config;

	/**
	 * @var ContainerInterface
	 */
	private $container;

	/**
	 * @var TransactionProvider
	 */
	private $transactionProvider;

	/**
	 * @var TransactionEntitySaver
	 */
	private $transactionEntitySaver;

	/**
	 * @var DefaultInvoiceGenerator
	 */
	private $invoiceGenerator;

	/**
	 * @var SuccessMailSender
	 */
	private $successMailSender;

	/**
	 * @var UnsuccessfulMailSender
	 */
	private $unsuccessfulMailSender;

	/**
	 * @var Transaction
	 */
	private $transaction;

	/**
	 * @param array $config
	 * @param ContainerInterface $container
	 * @param TransactionProvider $transactionProvider
	 * @param TransactionEntitySaver $transactionEntitySaver
	 * @param DefaultInvoiceGenerator $invoiceGenerator
	 * @param SuccessMailSender $successMailSender
	 * @param UnsuccessfulMailSender $unsuccessfulMailSender
	 */
	public function __construct(
		array $config,
		ContainerInterface $container,
		TransactionProvider $transactionProvider,
		TransactionEntitySaver $transactionEntitySaver,
		DefaultInvoiceGenerator $invoiceGenerator,
		SuccessMailSender $successMailSender,
		UnsuccessfulMailSender $unsuccessfulMailSender
	)
	{
		$this->config                 = $config;
		$this->container              = $container;
		$this->transactionProvider    = $transactionProvider;
		$this->transactionEntitySaver = $transactionEntitySaver;
		$this->invoiceGenerator       = $invoiceGenerator;
		$this->successMailSender      = $successMailSender;
		$this->unsuccessfulMailSender = $unsuccessfulMailSender;
	}

	/**
	 * @param SuccessfulData $data
	 * @return SuccessfulResult
	 * @throws Exception
	 */
	public function successful(SuccessfulData $data)
	{
		$result = new SuccessfulResult();
		$result->setSuccess(false);

		$this->transaction = $data->getTransaction();

		$this->handleConsecutiveNumberInYear();

		$this->reloadTransaction();

		$this->generateInvoiceNumber();

		$this->reloadTransaction();

		$generateInvoiceResult = $this->invoiceGenerator->generate(
			GenerateData::create()
				->setTransaction($this->transaction)
		);

		if (!$generateInvoiceResult->isSuccess())
		{
			$result->setErrors($generateInvoiceResult->getErrors());
			return $result;
		}

		$result->setSuccess(
			$this->successMailSender->send($data->getTransaction())
		);

		$this
			->getEventManager()
			->trigger(
				Event::PAYMENT_SUCCESSFUL,
				null,
				[
					'transaction' => $data->getTransaction(),
				]
			);

		return $result;
	}

	/**
	 * @param UnsuccessfulData $data
	 * @return UnsuccessfulResult
	 */
	public function unsuccessful(UnsuccessfulData $data)
	{
		$result = new UnsuccessfulResult();

		$result->setSuccess(
			$this->unsuccessfulMailSender->send($data->getTransaction())
		);

		$this
			->getEventManager()
			->trigger(
				Event::PAYMENT_UNSUCCESSFUL,
				null,
				[
					'transaction' => $data->getTransaction(),
				]
			);

		return $result;
	}

	/**
	 * @throws Exception
	 */
	private function generateInvoiceNumber()
	{
		/**
		 * @var InvoiceNumberGenerator $invoiceNumberGenerator
		 */
		$invoiceNumberGenerator = $this->container->get(
			$this->config['ecommerce']['invoice']['number']['generator']
		);

		$result = $invoiceNumberGenerator->generate(
			InvoiceNumberGenerateData::create()
				->setTransaction($this->transaction)
		);

		$transactionEntity = $this->transaction->getEntity();

		$transactionEntity->setInvoiceNumber(
			$result->getInvoiceNumber()
		);

		$this->transactionEntitySaver->save($transactionEntity);
	}

	/**
	 * @throws Exception
	 */
	private function handleConsecutiveNumberInYear()
	{
		$latestSuccessTransactionsInYear = $this->transactionProvider->filter(
			FilterChain::create()
				->addFilter(
					ConsecutiveSuccessNumberInYearFilter::isNotNull()
				)
				->addFilter(
					CreationYear::is(
						$this->transaction
							->getCreatedDate()
							->format('Y')
					)
				),
			OrderChain::create()
				->addOrder(ConsecutiveSuccessNumberInYear::desc())
		);

		$transactionEntity = $this->transaction->getEntity();

		$transactionEntity->setConsecutiveSuccessNumberInYear(
			$latestSuccessTransactionsInYear
				? $latestSuccessTransactionsInYear[0]->getConsecutiveSuccessNumberInYear() + 1
				: 1
		);

		$this->transactionEntitySaver->save($transactionEntity);
	}

	/**
	 * @throws Exception
	 */
	private function reloadTransaction()
	{
		$this->transaction = $this->transactionProvider->byId($this->transaction->getId());
	}
}