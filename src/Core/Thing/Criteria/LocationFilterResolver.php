<?php
namespace ImmediateSolutions\Core\Thing\Criteria;
use Doctrine\ORM\QueryBuilder;
use ImmediateSolutions\Support\Core\Criteria\AbstractResolver;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class LocationFilterResolver extends AbstractResolver
{
    /**
     * @param QueryBuilder $builder
     * @param string $name
     */
    public function whereNameSimilar(QueryBuilder $builder, $name)
    {
        $builder->andWhere($builder->expr()->like('l.name', ':name'))
            ->setParameter('name', '%' . addcslashes($name, '%_') . '%');
    }

}