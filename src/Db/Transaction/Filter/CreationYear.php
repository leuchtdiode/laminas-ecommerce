<?php
namespace Ecommerce\Db\Transaction\Filter;

use Common\Db\Filter;
use Doctrine\ORM\QueryBuilder;

class CreationYear implements Filter
{
	private int $year;

	public function __construct(int $year)
	{
		$this->year = $year;
	}

	public static function is(int $year): self
	{
		return new self($year);
	}

	public function addClause(QueryBuilder $queryBuilder): void
	{
		$expr = $queryBuilder->expr();

		$queryBuilder->andWhere(
			$expr->eq('YEAR(t.createdDate)', $this->year)
		);
	}
}