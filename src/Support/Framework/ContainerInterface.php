<?php
namespace ImmediateSolutions\Support\Framework;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface ContainerInterface
{
    /**
     * @param string $id
     * @return mixed
     */
    public function get($id);

    /**
     * @param string $id
     * @return bool
     */
    public function has($id);

    /**
     * @param callable $callback
     * @param array $arguments
     * @return mixed
     */
    public function call(callable $callback, array $arguments = []);
}