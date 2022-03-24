<?php
namespace Ecommerce\Db\Transaction\Filter;

use Common\Db\Filter\Equals;
use Doctrine\ORM\QueryBuilder;

class ProductNumber extends Equals
{
	private string $alias;

	/**
	 * @return string
	 */
	protected function getField(): string
	{
		return $this->alias . '.number';
	}

	public function addClause(QueryBuilder $queryBuilder): void
	{
		$this->alias = uniqid('p');

		$itemsAlias = uniqid('items');

		$queryBuilder
			->join('t.items', $itemsAlias)
			->join($itemsAlias . '.product', $this->alias);

		parent::addClause($queryBuilder);
	}
}