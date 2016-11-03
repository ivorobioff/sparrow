<?php
namespace ImmediateSolutions\Core\Document\Validation\Rules;
use ImmediateSolutions\Core\Document\Payloads\IdentifierPayload;
use ImmediateSolutions\Core\Document\Payloads\IdentifiersPayload;
use ImmediateSolutions\Core\Document\Services\DocumentService;
use ImmediateSolutions\Support\Validation\Error;
use ImmediateSolutions\Support\Validation\Rules\AbstractRule;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DocumentExists extends AbstractRule
{
    /**
     * @var DocumentService
     */
    private $documentService;

    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;

        $this->setIdentifier('exists');
        $this->setMessage('The document with the provided ID does not exist.');
    }

    /**
     *
     * @param IdentifierPayload|IdentifiersPayload $value
     * @return Error|null
     */
    public function check($value)
    {
        $ids = $value instanceof IdentifiersPayload ? $value->getIds() : $value->getId();

        if (! $this->documentService->exists($ids)) {
            return $this->getError();
        }

        return null;
    }
}