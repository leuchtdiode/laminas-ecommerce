<?php
namespace Ecommerce\Rest\Action\Customer\Transaction;

use Common\Hydration\ArrayHydratable;
use Ecommerce\Transaction\Transaction;

class GetListSuccessData implements ArrayHydratable
{
	/**
	 * @ObjectToArrayHydratorProperty
	 *
	 * @var Transaction[]
	 */
	private $transactions;

	/**
	 * @return GetListSuccessData
	 */
	public static function create()
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
	 * @return GetListSuccessData
	 */
	public function setTransactions(array $transactions): GetListSuccessData
	{
		$this->transactions = $transactions;
		return $this;
	}
}