<?php
namespace ImmediateSolutions\Support\Framework;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface ContainerInterface
{
    /**
     * @param string $id
     */
    public function get($id);

    /**
     * @param string $id
     * @return bool
     */
    public function has($id);

    /**
     * @param callable $callback
     * @return mixed
     */
    public function call(callable $callback);
}