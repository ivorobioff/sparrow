<?php
namespace ImmediateSolutions\Infrastructure\DAL\Session\Metadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use ImmediateSolutions\Core\User\Entities\User;
use ImmediateSolutions\Infrastructure\Doctrine\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class SessionMetadata extends AbstractMetadataProvider
{
    /**
     * @param ClassMetadataBuilder $builder
     * @return void
     */
    public function define(ClassMetadataBuilder $builder)
    {
        $builder->setTable('sessions');

        $builder
            ->createField('id', 'integer')
            ->makePrimaryKey()
            ->generatedValue()
            ->build();

        $builder
            ->createField('token', 'string')
            ->unique()
            ->build();

        $builder->createManyToOne('user', User::class)->build();

        $builder->createField('createdAt', 'datetime')->build();

        $builder->createField('expiresAt', 'datetime')->build();

    }
}