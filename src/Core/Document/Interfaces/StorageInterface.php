<?php
namespace ImmediateSolutions\Core\Document\Interfaces;
use ImmediateSolutions\Core\Document\Objects\FileDescriptor;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface StorageInterface
{
    /**
     * @param string|resource $location
     * @param string $dest
     */
    public function putFileIntoRemoteStorage($location, $dest);

	/**
	 * @param array $uris
	 */
	public function removeFilesFromRemoteStorage(array $uris);

    /**
     *
     * @param string|resource $location
     * @return bool
     */
    public function isFileReadable($location);

    /**
     *
     * @param string|resource $location
     * @return FileDescriptor
     */
    public function getFileDescriptor($location);
}