<?php
namespace Ecommerce\Payment\PostPayment;

use Ecommerce\Transaction\Invoice\DefaultGenerator as DefaultInvoiceGenerator;
use Ecommerce\Transaction\Invoice\GenerateData;

class Handler
{
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
	 * @param DefaultInvoiceGenerator $invoiceGenerator
	 * @param SuccessMailSender $successMailSender
	 * @param UnsuccessfulMailSender $unsuccessfulMailSender
	 */
	public function __construct(
		DefaultInvoiceGenerator $invoiceGenerator,
		SuccessMailSender $successMailSender,
		UnsuccessfulMailSender $unsuccessfulMailSender
	)
	{
		$this->invoiceGenerator       = $invoiceGenerator;
		$this->successMailSender      = $successMailSender;
		$this->unsuccessfulMailSender = $unsuccessfulMailSender;
	}

	/**
	 * @param SuccessfulData $data
	 * @return SuccessfulResult
	 */
	public function successful(SuccessfulData $data)
	{
		$result = new SuccessfulResult();
		$result->setSuccess(false);

		$generateInvoiceResult = $this->invoiceGenerator->generate(
			GenerateData::create()
				->setTransaction($data->getTransaction())
		);

		if (!$generateInvoiceResult->isSuccess())
		{
			$result->setErrors($generateInvoiceResult->getErrors());
			return $result;
		}

		$result->setSuccess(
			$this->successMailSender->send($data->getTransaction())
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

		return $result;
	}
}