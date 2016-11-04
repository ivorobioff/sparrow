<?php
namespace ImmediateSolutions\Core\Document\Validation\Inflators;

use ImmediateSolutions\Core\Document\Entities\Document;
use ImmediateSolutions\Core\Document\Services\DocumentService;
use ImmediateSolutions\Core\Document\Validation\Rules\DocumentExists;
use ImmediateSolutions\Core\Document\Validation\Rules\DocumentPermissions;
use ImmediateSolutions\Support\Framework\ContainerInterface;
use ImmediateSolutions\Support\Validation\Property;
use ImmediateSolutions\Support\Validation\Rules\Obligate;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DocumentInflator
{
	/**
	 * @var ContainerInterface $container
	 */
	protected $container;

	/**
	 * @var bool
	 */
	private $isRequired = false;

	/**
	 * @var Document[]
	 */
	private $trustedDocuments = [];

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	/**
	 * @param bool $bool
	 * @return $this
	 */
	public function setRequired($bool)
	{
		$this->isRequired = $bool;
		return $this;
	}

	/**
	 * @param Document[] $documents
	 * @return $this
	 */
	public function setTrustedDocuments($documents)
	{
		$this->trustedDocuments = $documents;
		return $this;
	}

	/**
	 * @param Property $property
	 */
	public function __invoke(Property $property)
	{
		/**
		 * @var DocumentService $documentService
		 */
		$documentService = $this->container->get(DocumentService::class);

		if ($this->isRequired){
			$property->addRule(new Obligate());
		}

		$property
			->addRule(new DocumentExists($documentService))
			->addRule(new DocumentPermissions($this->container, $this->trustedDocuments));
	}
}