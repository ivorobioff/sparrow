<?php
namespace ImmediateSolutions\Core\Document\Objects;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class FileDescriptor
{
    /**
     * @var int
     */
    private $size;
    public function setSize($size) { $this->size = $size; }
    public function getSize() { return $this->size; }
}