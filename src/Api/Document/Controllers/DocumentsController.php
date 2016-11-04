<?php
namespace ImmediateSolutions\Api\Document\Controllers;
use ImmediateSolutions\Api\Document\Processors\DocumentsProcessor;
use ImmediateSolutions\Api\Document\Serializers\DocumentSerializer;
use ImmediateSolutions\Api\Support\Controller;
use ImmediateSolutions\Core\Document\Services\DocumentService;
use ImmediateSolutions\Support\Validation\ErrorsThrowableCollection;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DocumentsController extends Controller
{
    /**
     * @var DocumentService
     */
    private $documentService;

    /**
     * @param DocumentService $documentService
     */
    public function initialize(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    /**
     * @param DocumentsProcessor $processor
     * @return ResponseInterface
     */
    public function store(DocumentsProcessor $processor)
    {
        try {
            $document = $this->documentService->create($processor->createPayload());
        } catch (ErrorsThrowableCollection $errors) {
            $errors['document'] = $errors['location'];
            unset($errors['location']);
            throw $errors;
        }

        return $this->reply->single($document, $this->serializer(DocumentSerializer::class));
    }
}