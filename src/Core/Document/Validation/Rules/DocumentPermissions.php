<?php
namespace ImmediateSolutions\Core\Document\Validation\Rules;

use DateTime;
use ImmediateSolutions\Core\Document\Entities\Document;
use ImmediateSolutions\Core\Document\Interfaces\DocumentPreferenceInterface;
use ImmediateSolutions\Core\Document\Payloads\IdentifierPayload;
use ImmediateSolutions\Core\Document\Payloads\IdentifiersPayload;
use ImmediateSolutions\Core\Document\Services\DocumentService;
use ImmediateSolutions\Support\Framework\ContainerInterface;
use ImmediateSolutions\Support\Validation\Error;
use ImmediateSolutions\Support\Validation\Rules\AbstractRule;

/**

 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DocumentPermissions extends AbstractRule
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var DocumentPreferenceInterface
     */
    private $preference;

	/**
	 * @var Document[]
	 */
	private $trustedDocuments = [];

    /**
     * @param ContainerInterface $container
	 * @param Document[] $trustedDocuments
     */
    public function __construct(ContainerInterface $container, $trustedDocuments = [])
    {
        $this->container = $container;
		$this->trustedDocuments = $trustedDocuments;
        $this->preference = $container->get(DocumentPreferenceInterface::class);

        $this->setIdentifier('permissions');
        $this->setMessage('Unable to access one or several documents with the provided ID(s).');
    }

    /**
     * @param IdentifierPayload|IdentifiersPayload $identifiers
     * @return Error|null
     */
    public function check($identifiers)
    {
        if (!$identifiers instanceof IdentifiersPayload) {
            $identifiers = [$identifiers];
        }

        foreach ($identifiers as $identifier) {
            if (!$this->checkSingle($identifier)) {
                return $this->getError();
            }
        }

        return null;
    }

    /**
     * @param IdentifierPayload $identifier
     * @return bool
     */
    private function checkSingle(IdentifierPayload $identifier)
    {
        /**
         * @var DocumentService $documentService
         */
        $documentService = $this->container->get(DocumentService::class);

        $document = $documentService->get($identifier->getId());

        return $this->grantsWithTrusted($document) || $this->grantsWithToken($identifier, $document);
    }

	/**
	 * @param Document $document
	 * @return bool
	 */
	private function grantsWithTrusted(Document $document)
	{
		foreach ($this->trustedDocuments as $trustedDocument){
			if ($trustedDocument->getId() == $document->getId()){
				return true;
			}
		}

		return false;
	}

    /**
     * @param IdentifierPayload $identifier
     * @param Document $document
     * @return bool
     */
    private function grantsWithToken(IdentifierPayload $identifier, Document $document)
    {
        $token = $identifier->getToken();

        if (!$token) {
            return false;
        }

        $tokenExpiresAt = clone $document->getUploadedAt();
        $tokenExpiresAt->modify('+' . $this->preference->getLifeTime() . ' minutes');

        return $token === $document->getToken() && $tokenExpiresAt > new DateTime();
    }
}