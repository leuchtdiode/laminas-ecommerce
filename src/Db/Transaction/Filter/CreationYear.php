<?php
namespace Ecommerce\Db\Transaction\Filter;

use Common\Db\Filter;
use Doctrine\ORM\QueryBuilder;

class CreationYear implements Filter
{
	/**
	 * @var int
	 */
	private $year;

	/**
	 * @param int $year
	 */
	public function __construct(int $year)
	{
		$this->year = $year;
	}

	/**
	 * @param $year
	 * @return CreationYear
	 */
	public static function is($year)
	{
		return new self($year);
	}

	/**
	 * @param QueryBuilder $queryBuilder
	 */
	public function addClause(QueryBuilder $queryBuilder)
	{
		$expr = $queryBuilder->expr();

		$queryBuilder->andWhere(
			$expr->eq('YEAR(t.createdDate)', $this->year)
		);
	}
}