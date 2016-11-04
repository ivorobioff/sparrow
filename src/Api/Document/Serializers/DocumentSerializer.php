<?php
namespace ImmediateSolutions\Api\Document\Serializers;
use ImmediateSolutions\Api\Support\Serializer;
use ImmediateSolutions\Core\Document\Entities\Document;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DocumentSerializer extends Serializer
{
    public function __invoke(Document $document)
    {
        return [
            'id' => $document->getId()
        ];
    }
}