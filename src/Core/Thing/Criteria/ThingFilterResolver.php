<?php
namespace ImmediateSolutions\Core\Thing\Criteria;
use Doctrine\ORM\QueryBuilder;
use ImmediateSolutions\Core\Thing\Enums\Attitude;
use ImmediateSolutions\Support\Core\Criteria\AbstractResolver;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ThingFilterResolver extends AbstractResolver
{
    /**
     * @param QueryBuilder $builder
     * @param int $id
     */
    public function whereCategoryEqual(QueryBuilder $builder, $id)
    {
        $builder
            ->andWhere($builder->expr()->eq('t.category', ':category'))
            ->setParameter('category', $id);
    }

    /**
     * @param QueryBuilder $builder
     * @param int $id
     */
    public function whereLocationContain(QueryBuilder $builder, $id)
    {
        $builder
            ->andWhere($builder->expr()->isMemberOf(':location', 't.locations'))
            ->setParameter('location', $id);
    }

    /**
     * @param QueryBuilder $builder
     * @param Attitude $attitude
     */
    public function whereAttitudeEqual(QueryBuilder $builder, Attitude $attitude)
    {
        $builder
            ->andWhere($builder->expr()->eq('t.attitude', ':attitude'))
            ->setParameter('attitude', (string) $attitude);
    }

    /**
     * @param QueryBuilder $builder
     * @param string $query
     */
    public function whereQuerySimilar(QueryBuilder $builder, $query)
    {
        $name = $description = '%' . addcslashes($query, '%_') . '%';

        $builder
            ->andWhere('t.name LIKE :name  OR t.description LIKE :description')
            ->setParameter('name', $name)
            ->setParameter('description', $description);
    }
}