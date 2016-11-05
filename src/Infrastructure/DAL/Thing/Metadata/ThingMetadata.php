<?php
namespace ImmediateSolutions\Infrastructure\DAL\Thing\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use ImmediateSolutions\Core\Document\Entities\Document;
use ImmediateSolutions\Core\Thing\Entities\Category;
use ImmediateSolutions\Core\Thing\Entities\Location;
use ImmediateSolutions\Core\User\Entities\User;
use ImmediateSolutions\Infrastructure\DAL\Thing\Types\AttitudeType;
use ImmediateSolutions\Infrastructure\Doctrine\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ThingMetadata extends AbstractMetadataProvider
{
    /**
     * @param ClassMetadataBuilder $builder
     * @return void
     */
    public function define(ClassMetadataBuilder $builder)
    {
        $builder->setTable('things');

        $builder
            ->createField('id', 'integer')
            ->makePrimaryKey()
            ->generatedValue()
            ->build();

        $builder
            ->createField('name', 'string')
            ->build();

        $builder
            ->createField('description', 'text')
            ->nullable(true)
            ->build();

        $builder
            ->createField('attitude', AttitudeType::class)
            ->build();

        $builder
            ->createField('rate', 'smallint')
            ->nullable(true)
            ->build();

        $builder
            ->createManyToOne('image', Document::class)
            ->build();

        $builder
            ->createManyToOne('user', User::class)
            ->addJoinColumn('user_id', 'id', true, false, 'CASCADE')
            ->build();

        $builder
            ->createManyToOne('category', Category::class)
            ->addJoinColumn('category_id', 'id', true, false, 'SET NULL')
            ->build();

        $builder
            ->createManyToMany('locations', Location::class)
            ->setJoinTable('things_locations')
            ->build();

        $builder
            ->createField('createdAt', 'datetime')
            ->build();

    }
}