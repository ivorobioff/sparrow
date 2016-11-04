<?php
namespace ImmediateSolutions\Core\Document\Interfaces;
use Psr\Http\Message\UploadedFileInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface StorageInterface
{
    /**
     * @param UploadedFileInterface $file
     * @param string $uri
     */
    public function move(UploadedFileInterface $file, $uri);

    /**
     * @param string|array $uri
     */
    public function delete($uri);
}