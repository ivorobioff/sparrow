<?php
namespace ImmediateSolutions\Infrastructure\DAL\Document\Metadata;
use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use ImmediateSolutions\Infrastructure\Doctrine\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DocumentMetadata extends AbstractMetadataProvider
{
    /**
     * @param ClassMetadataBuilder $builder
     * @return void
     */
    public function define(ClassMetadataBuilder $builder)
    {
        $builder->setTable('documents');

        $builder
            ->createField('id', 'integer')
            ->makePrimaryKey()
            ->generatedValue()
            ->build();

        $builder
            ->createField('token', 'string')
            ->unique()
            ->build();


        $builder
            ->createField('usage', 'integer')
            ->columnName('`usage`')
            ->build();

        $builder
            ->createField('uri', 'string')
            ->nullable(true)
            ->build();


        $builder
            ->createField('format', 'string')
            ->length(50)
            ->build();

        $builder
            ->createField('size', 'integer')
            ->build();

        $builder
            ->createField('uploadedAt', 'datetime')
            ->build();
    }
}