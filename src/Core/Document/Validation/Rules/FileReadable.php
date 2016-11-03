<?php
namespace ImmediateSolutions\Core\Document\Validation\Rules;
use ImmediateSolutions\Core\Document\Interfaces\StorageInterface;
use ImmediateSolutions\Support\Validation\Error;
use ImmediateSolutions\Support\Validation\Rules\AbstractRule;
/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class FileReadable extends AbstractRule
{

    /**
     * @var StorageInterface
     */
    private $storage;

    /**
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;

        $this->setIdentifier('file-access');
        $this->setMessage('Cannot access the uploaded file.');
    }

    /**
     * @param mixed $location
     * @return Error|null
     */
    public function check($location)
    {
        if (! $this->storage->isFileReadable($location)) {
            return $this->getError();
        }

        return null;
    }
}