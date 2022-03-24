<?php
namespace Ecommerce\Db\Product\Attribute;

use Common\Db\EntityRepository;
use Common\Db\FilterChain;
use Common\Db\OrderChain;

/**
 * @method Entity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entity[] filter(FilterChain $filterChain, OrderChain $orderChain = null, int $offset = 0, int $limit = PHP_INT_MAX, bool $distinct = false)
 */
class Repository extends EntityRepository
{

}