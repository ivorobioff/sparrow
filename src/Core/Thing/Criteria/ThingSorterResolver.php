<?php
namespace ImmediateSolutions\Core\Thing\Criteria;
use Doctrine\ORM\QueryBuilder;
use ImmediateSolutions\Support\Core\Criteria\Sorting\AbstractResolver;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ThingSorterResolver extends AbstractResolver
{
    /**
     * @param QueryBuilder $builder
     * @param string $direction
     */
    public function byCreatedAt(QueryBuilder $builder, $direction)
    {
        $builder->addOrderBy('t.createdAt', $direction);
    }
}