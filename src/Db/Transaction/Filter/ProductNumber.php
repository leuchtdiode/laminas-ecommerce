<?php
namespace Ecommerce\Db\Transaction\Filter;

use Common\Db\Filter\Equals;
use Doctrine\ORM\QueryBuilder;

class ProductNumber extends Equals
{
	/**
	 * @var string
	 */
	private $alias;

	/**
	 * @return string
	 */
	protected function getField()
	{
		return $this->alias . '.number';
	}

	/**
	 * @return string
	 */
	protected function getParameterName()
	{
		return 'transactionProductNumber';
	}

	/**
	 * @param QueryBuilder $queryBuilder
	 */
	public function addClause(QueryBuilder $queryBuilder)
	{
		$this->alias = uniqid('p');

		$itemsAlias = uniqid('items');

		$queryBuilder
			->join('t.items', $itemsAlias)
			->join($itemsAlias . '.product', $this->alias);

		parent::addClause($queryBuilder);
	}
}