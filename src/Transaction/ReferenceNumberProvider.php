<?php
namespace Ecommerce\Transaction;

use Ecommerce\Db\Transaction\Repository;
use function range;

class ReferenceNumberProvider
{
	private Repository $repository;

	const LENGTH = 8;

	public function __construct(Repository $repository)
	{
		$this->repository = $repository;
	}

	public function create(): string
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

	private function exists(string $referenceNumber): bool
	{
		return !empty($this->repository->findOneBy([ 'referenceNumber' => $referenceNumber]));
	}
}