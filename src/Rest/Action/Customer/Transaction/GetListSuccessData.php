<?php
namespace Ecommerce\Rest\Action\Customer\Transaction;

use Common\Hydration\ArrayHydratable;
use Common\Hydration\ObjectToArrayHydratorProperty;
use Ecommerce\Transaction\Transaction;

class GetListSuccessData implements ArrayHydratable
{
	/**
	 * @var Transaction[]
	 */
	#[ObjectToArrayHydratorProperty]
	private array $transactions;

	public static function create(): self
	{
		return new self();
	}

	/**
	 * @return Transaction[]
	 */
	public function getTransactions(): array
	{
		return $this->transactions;
	}

	/**
	 * @param Transaction[] $transactions
	 */
	public function setTransactions(array $transactions): GetListSuccessData
	{
		$this->transactions = $transactions;
		return $this;
	}
}