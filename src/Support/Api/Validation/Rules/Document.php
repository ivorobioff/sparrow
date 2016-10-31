<?php
namespace ImmediateSolutions\Support\Api\Validation\Rules;
use ImmediateSolutions\Support\Validation\Error;
use ImmediateSolutions\Support\Validation\Rules\AbstractRule;
use Psr\Http\Message\UploadedFileInterface;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Document extends AbstractRule
{
    /**
     * File constructor.
     */
    public function __construct()
    {
        $this->setIdentifier('document');
        $this->setMessage('Document is not attached.');
    }

    /**
     *
     * @param mixed $value
     * @return Error|null
     */
    public function check($value)
    {
        if (!$value instanceof UploadedFileInterface) {
            return $this->getError();
        }

        return null;
    }
}