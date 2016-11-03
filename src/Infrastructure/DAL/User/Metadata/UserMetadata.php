<?php
namespace ImmediateSolutions\Infrastructure\DAL\User\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use ImmediateSolutions\Infrastructure\Doctrine\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class UserMetadata extends AbstractMetadataProvider
{
    /**
     * @param ClassMetadataBuilder $builder
     * @return void
     */
    public function define(ClassMetadataBuilder $builder)
    {
        $builder->setTable('users');

        $builder
            ->createField('id', 'integer')
            ->makePrimaryKey()
            ->generatedValue()
            ->build();

        $builder
            ->createField('email', 'string')
            ->build();

        $builder
            ->createField('password', 'string')
            ->build();

        $builder
            ->createField('firstName', 'string')
            ->build();

        $builder
            ->createField('lastName', 'string')
            ->build();

        $builder
            ->createField('createdAt', 'datetime')
            ->build();
    }
}