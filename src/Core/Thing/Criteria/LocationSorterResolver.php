<?php
namespace ImmediateSolutions\Core\Thing\Criteria;
use Doctrine\ORM\QueryBuilder;
use ImmediateSolutions\Support\Core\Criteria\Sorting\AbstractResolver;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class LocationSorterResolver extends AbstractResolver
{
    /**
     * @param QueryBuilder $builder
     * @param $direction
     */
    public function byId(QueryBuilder $builder, $direction)
    {
        $builder->addOrderBy('l.id', $direction);
    }
}