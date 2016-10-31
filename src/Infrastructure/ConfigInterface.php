<?php
namespace ImmediateSolutions\Infrastructure;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface ConfigInterface
{
    /**
     * @param string $path
     * @param mixed $default
     * @return mixed
     */
    public function get($path, $default);
}