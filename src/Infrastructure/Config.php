<?php
namespace ImmediateSolutions\Infrastructure;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Config
{
    /**
     * @var array
     */
    private $source = [];

    public function __construct(array $source)
    {
        $this->source = $source;
    }

    /**
     * @param string $path
     * @param mixed $default
     * @return null
     */
    public function get($path, $default = null)
    {
        return array_get($this->source, $path, $default);
    }

    /**
     * @param string $path
     * @return bool
     */
    public function has($path)
    {
        return array_has($this->source, $path);
    }
}