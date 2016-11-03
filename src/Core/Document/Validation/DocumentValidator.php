<?php
namespace ImmediateSolutions\Core\Document\Validation;

use ImmediateSolutions\Core\Document\Interfaces\StorageInterface;
use ImmediateSolutions\Core\Document\Validation\Rules\FileReadable;
use ImmediateSolutions\Support\Validation\AbstractThrowableValidator;
use ImmediateSolutions\Support\Validation\Binder;
use ImmediateSolutions\Support\Validation\Property;
use ImmediateSolutions\Support\Validation\Rules\Obligate;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DocumentValidator extends AbstractThrowableValidator
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
    }

    /**
     * @param Binder $binder
     * @return void
     */
    protected function define(Binder $binder)
    {
        $binder->bind('location', function (Property $property) {
            $property
				->addRule(new Obligate())
                ->addRule(new FileReadable($this->storage));
        });
    }
}