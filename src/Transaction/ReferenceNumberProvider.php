<?php
namespace Ecommerce\Transaction;

use Ecommerce\Db\Transaction\Repository;
use function range;

class ReferenceNumberProvider
{
	/**
	 * @var Repository
	 */
	private $repository;

	const LENGTH = 8;

	/**
	 * @param Repository $repository
	 */
	public function __construct(Repository $repository)
	{
		$this->repository = $repository;
	}

	/**
	 * @return string
	 */
	public function create()
	{
		$chars = range('A', 'Z');

		while (true)
		{
			$referenceNumber = '';

			for ($i = 0; $i < self::LENGTH; $i++)
			{
				shuffle($chars);

				$referenceNumber .= $chars[$i];
			}

			if (!$this->exists($referenceNumber))
			{
				return $referenceNumber;
			}
		}

		return '';
	}

	/**
	 * @param string $referenceNumber
	 * @return bool
	 */
	private function exists(string $referenceNumber)
	{
		return !empty($this->repository->findOneBy([ 'referenceNumber' => $referenceNumber]));
	}
}