<?php
namespace ImmediateSolutions\Api\Document\Processors;
use ImmediateSolutions\Api\Support\Processor;
use ImmediateSolutions\Core\Document\Payloads\DocumentPayload;
use ImmediateSolutions\Support\Validation\Binder;
use ImmediateSolutions\Support\Validation\Property;
use ImmediateSolutions\Support\Validation\Rules\Obligate;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DocumentsProcessor extends Processor
{
    public function rules(Binder $binder)
    {
        $binder->bind('document', function(Property $property){
            $property->addRule(new Obligate());
        });
    }

    /**
     * @return DocumentPayload
     */
    public function createPayload()
    {
        $payload = new DocumentPayload();

        return $payload;
    }
}