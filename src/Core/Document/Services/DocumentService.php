<?php
namespace ImmediateSolutions\Core\Document\Services;

use ImmediateSolutions\Core\Document\Entities\Document;
use ImmediateSolutions\Core\Document\Interfaces\DocumentPreferenceInterface;
use ImmediateSolutions\Core\Document\Interfaces\StorageInterface;
use ImmediateSolutions\Core\Document\Payloads\DocumentPayload;
use ImmediateSolutions\Core\Document\Validation\DocumentValidator;
use ImmediateSolutions\Core\Support\Service;
use ImmediateSolutions\Support\Core\Interfaces\TokenGeneratorInterface;
use ImmediateSolutions\Support\Other\Tracker;
use Traversable;
use DateTime;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DocumentService extends Service
{
    /**
     * @param DocumentPayload $payload
     * @return Document
     */
    public function create(DocumentPayload $payload)
    {
		/**
		 * @var StorageInterface $storage
		 */
		$storage = $this->container->get(StorageInterface::class);

        (new DocumentValidator($storage))->validate($payload);

        $location = $payload->getLocation();

        $descriptor = $storage->getFileDescriptor($location);

        $document = new Document();

        /**
         * @var TokenGeneratorInterface $tokenGenerator
         */
        $tokenGenerator = $this->container->get(TokenGeneratorInterface::class);

        $document->setToken($tokenGenerator->generate());

        $document->setSize($descriptor->getSize());

        $document->setName($payload->getSuggestedName());

        $document->setUri('');
        $document->setUploadedAt(new DateTime());

        $this->entityManager->persist($document);
        $this->entityManager->flush();

        $remoteUri = '/documents/' . $document->getId() . '/' . $document->getName();

        $storage->putFileIntoRemoteStorage($location, $remoteUri);

        $document->setUri($remoteUri);

        $this->entityManager->persist($document);
        $this->entityManager->flush();

        return $document;
    }

    /**
     * @param int $id
     * @return Document
     */
    public function get($id)
    {
        return $this->entityManager->find(Document::class, $id);
    }

    /**
     * @param int|int[] $id
     * @return bool
     */
    public function exists($id)
    {
        return $this->entityManager->getRepository(Document::class)->exists(['id' => $id]);
    }


	public function deleteAllUnused()
	{
		/**
		 * @var DocumentPreferenceInterface $preference
		 */
		$preference = $this->container->get(DocumentPreferenceInterface::class);

		/**
		 * @var StorageInterface $storage
		 */
		$storage = $this->container->get(StorageInterface::class);

		$builder = $this->entityManager->createQueryBuilder();

		$expression = 'DATE_ADD(d.uploadedAt, '.($preference->getLifeTime() * 60).', \'second\')';

		/**
		 * @var Traversable
		 */
		$documents = $builder
			->select('d')
			->from(Document::class, 'd')
			->where($builder->expr()->lt($expression, ':now'))
			->andWhere($builder->expr()->eq('d.usage', ':usage'))
			->setParameters(['now' => new DateTime(), 'usage' => 0])
			->getQuery()
			->iterate();

		$uris = [];

		$tracker = new Tracker($documents, 100);

		foreach($tracker as $document){

			/**
			 * @var Document $document
			 */
			$document = $document[0];

            $uris[] = $document->getUri();

			$this->entityManager->remove($document);

			if ($tracker->isTime()){
				$storage->removeFilesFromRemoteStorage($uris);
				$this->entityManager->flush();
				$this->entityManager->clear();
				$uris = [];
			}
		}

		$storage->removeFilesFromRemoteStorage($uris);
		$this->entityManager->flush();
	}
}