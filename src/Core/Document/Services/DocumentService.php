<?php
namespace ImmediateSolutions\Core\Document\Services;

use ImmediateSolutions\Core\Document\Entities\Document;
use ImmediateSolutions\Core\Document\Interfaces\DocumentPreferenceInterface;
use ImmediateSolutions\Core\Document\Interfaces\StorageInterface;
use ImmediateSolutions\Core\Support\Service;
use ImmediateSolutions\Support\Core\Interfaces\TokenGeneratorInterface;
use ImmediateSolutions\Support\Other\Tracker;
use Psr\Http\Message\UploadedFileInterface;
use Traversable;
use DateTime;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DocumentService extends Service
{
    /**
     * @param UploadedFileInterface $file
     * @return Document
     */
    public function create(UploadedFileInterface $file)
    {
		/**
		 * @var StorageInterface $storage
		 */
		$storage = $this->container->get(StorageInterface::class);

        if ($file->getError() !== UPLOAD_ERR_OK){

        }

        $document = new Document();

        /**
         * @var TokenGeneratorInterface $tokenGenerator
         */
        $tokenGenerator = $this->container->get(TokenGeneratorInterface::class);

        $document->setToken($tokenGenerator->generate());

        $document->setSize($file->getSize());

        $document->setName($file->getClientFilename());
        $document->setFormat($file->getClientMediaType());

        $document->setUri('');
        $document->setUploadedAt(new DateTime());

        $this->entityManager->persist($document);
        $this->entityManager->flush();

        $uri = '/documents/' . $document->getId() . '/' . $document->getName();

        $storage->move($file, $uri);

        $document->setUri($uri);

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
        if (is_array($id)){
            return count($id) === $this->entityManager
                ->getRepository(Document::class)->count(['id' => ['in', $id]]);
        }

        return $this->entityManager->getRepository(Document::class)
            ->exists(['id' => $id]);
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
				$storage->delete($uris);
				$this->entityManager->flush();
				$this->entityManager->clear();
				$uris = [];
			}
		}

		$storage->delete($uris);
		$this->entityManager->flush();
	}
}