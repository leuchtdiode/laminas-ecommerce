<?php
namespace Ecommerce\Payment\MethodHandler\PayPal;

use AsyncQueue\Item\ProcessData;
use AsyncQueue\Item\Processor;
use AsyncQueue\Item\ProcessResult;
use Ecommerce\Db\Transaction\Saver as TransactionEntitySaver;
use Ecommerce\Payment\PostPayment\Handler as PostPaymentHandler;
use Ecommerce\Payment\PostPayment\SuccessfulData;
use Ecommerce\Payment\PostPayment\UnsuccessfulData;
use Ecommerce\Transaction\Provider as TransactionProvider;
use Ecommerce\Transaction\Status;
use Exception;
use Log\Log;
use PayPal\Api\Payment;

class PendingCheckProcessor implements Processor
{
	const ID = 'payPalPendingCheck';

	private TransactionProvider $transactionProvider;

	private TransactionEntitySaver $transactionEntitySaver;

	private Api $api;

	private PostPaymentHandler $postPaymentHandler;

	public function __construct(
		TransactionProvider $transactionProvider,
		TransactionEntitySaver $transactionEntitySaver,
		Api $api,
		PostPaymentHandler $postPaymentHandler
	)
	{
		$this->transactionProvider    = $transactionProvider;
		$this->transactionEntitySaver = $transactionEntitySaver;
		$this->api                    = $api;
		$this->postPaymentHandler     = $postPaymentHandler;
	}

	public function process(ProcessData $data): ProcessResult
	{
		$result = new ProcessResult();

		try
		{
			$transactionId = $data->getPayLoad()['transactionId'];

			$transaction = $this->transactionProvider->byId($transactionId);

			if (!$transaction)
			{
				$result->setSuccess(false);

				return $result;
			}

			$transactionEntity = $transaction->getEntity();

			$payment = Payment::get($transaction->getForeignId(), $this->api);

			if (($payPalTransaction = $payment->getTransactions()[0]) && ($resource = $payPalTransaction->getRelatedResources()[0]) && ($sale = $resource->getSale()))
			{
				Log::info($transactionId . ': Loaded PayPal transaction');
				Log::info($transactionId . ': State is ' . $payment->getState());

				if ($payment->getState() == State::APPROVED)
				{
					Log::info($transactionId . ': Sale state is ' . $sale->getState());

					if ($sale->getState() == State::SALE_PENDING)
					{
						$result->setRetryInSeconds(60);
					}
					else
					{
						if ($sale->getState() == State::SALE_COMPLETED)
						{
							$transactionEntity->setStatus(Status::SUCCESS);

							$postPaymentResult = $this->postPaymentHandler->successful(
								SuccessfulData::create()
									->setTransaction($transaction)
							);

							$result->setSuccess(
								$postPaymentResult->isSuccess()
							);
						}
						else
						{
							if ($sale->getState() == State::SALE_DENIED)
							{
								Log::info($transactionId . ': Sale state is denied');

								$transactionEntity->setStatus(Status::ERROR);

								$postPaymentResult = $this->postPaymentHandler->unsuccessful(
									UnsuccessfulData::create()
										->setTransaction($transaction)
								);

								$result->setSuccess(
									$postPaymentResult->isSuccess()
								);
							}
						}
					}
				}
				else
				{
					if ($payment->getState() == State::CANCELLED)
					{
						$transactionEntity->setStatus(Status::CANCELLED);
					}
					else
					{
						if (in_array($payment->getState(), [State::EXPIRED, State::FAILED]))
						{
							$transactionEntity->setStatus(Status::ERROR);
						}
					}

					$result->setSuccess(true);
				}

				$this->transactionEntitySaver->save($transactionEntity);
			}
		}
		catch (Exception $ex)
		{
			Log::error($ex);

			$result->setSuccess(false);
		}

		return $result;
	}
}