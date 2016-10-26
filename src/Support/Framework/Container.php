<?php
namespace ImmediateSolutions\Support\Framework;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Container implements ContainerPopulatorInterface, ContainerInterface
{
    /**
     * @param string $target
     * @param callable|string $source
     * @return $this
     */
    public function service($target, $source)
    {
        // TODO: Implement service() method.
    }

    /**
     * @param string $target
     * @param string|callable $source
     * @return $this
     */
    public function instance($target, $source)
    {
        // TODO: Implement instance() method.
    }

    /**
     * @param string $id
     */
    public function get($id)
    {
        // TODO: Implement get() method.
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has($id)
    {
        // TODO: Implement has() method.
    }

    /**
     * @param callable $callback
     * @return mixed
     */
    public function call(callable $callback)
    {
        // TODO: Implement call() method.
    }
}