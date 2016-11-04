<?php
namespace ImmediateSolutions\Infrastructure;
use ImmediateSolutions\Core\Document\Interfaces\StorageInterface;
use Psr\Http\Message\UploadedFileInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Storage implements StorageInterface
{
    /**
     * @param UploadedFileInterface $file
     * @param string $uri
     */
    public function move(UploadedFileInterface $file, $uri)
    {
        $path = APP_PATH.'/uploads'.$uri;

        mkdir(dirname($path), 0755, true);

        $file->moveTo($path);
    }

    /**
     * @param string|array $uri
     */
    public function delete($uri)
    {
        if (!is_array($uri)){
            $uri = [$uri];
        }

        foreach ($uri as $path){
            unlink(APP_PATH.'/uploads'.$path);
        }
    }
}