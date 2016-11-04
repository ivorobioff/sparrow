<?php
namespace ImmediateSolutions\Infrastructure\DAL\Thing\Metadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use ImmediateSolutions\Core\Thing\Entities\Category;
use ImmediateSolutions\Core\User\Entities\User;
use ImmediateSolutions\Infrastructure\Doctrine\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CategoryMetadata extends AbstractMetadataProvider
{
    /**
     * @param ClassMetadataBuilder $builder
     * @return void
     */
    public function define(ClassMetadataBuilder $builder)
    {
        $builder->setTable('categories');

        $builder
            ->createField('id', 'integer')
            ->makePrimaryKey()
            ->generatedValue()
            ->build();

        $builder
            ->createField('title', 'string')
            ->build();

        $builder
            ->createManyToOne('user', User::class)
            ->addJoinColumn('user_id', 'id', true, false, 'CASCADE')
            ->build();

        $builder
            ->createManyToOne('parent', Category::class)
            ->addJoinColumn('parent_id', 'id', true, false, 'CASCADE')
            ->inversedBy('children')
            ->build();

        $builder
            ->createOneToMany('children', Category::class)
            ->mappedBy('parent')
            ->build();
    }
}