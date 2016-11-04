<?php
namespace ImmediateSolutions\Api\Document\Processors;
use ImmediateSolutions\Api\Support\Processor;
use ImmediateSolutions\Support\Validation\Error;
use ImmediateSolutions\Support\Validation\ErrorsThrowableCollection;
use Psr\Http\Message\UploadedFileInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DocumentsProcessor extends Processor
{
    public function validate()
    {
        if (count($this->request->getUploadedFiles()) === 0){
            ErrorsThrowableCollection::throwError(
                'document', new Error('exists', 'The file has not been uploaded'));
        }
    }

    /**
     * @return UploadedFileInterface
     */
    public function getUploadedFile()
    {
       return array_first($this->request->getUploadedFiles());
    }
}