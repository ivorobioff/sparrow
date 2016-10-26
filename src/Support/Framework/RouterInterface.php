<?php
namespace ImmediateSolutions\Support\Framework;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface RouterInterface
{
    /**
     * @param string $pattern
     * @param callable|string $callback
     */
    public function get($pattern, $callback);

    /**
     * @param string $pattern
     * @param callable|string $callback
     */
    public function post($pattern, $callback);

    /**
     * @param string $pattern
     * @param callable|string $callback
     */
    public function put($pattern, $callback);

    /**
     * @param string $pattern
     * @param callable|string $callback
     */
    public function delete($pattern, $callback);

    /**
     * @param string $pattern
     * @param callable|string $callback
     */
    public function patch($pattern, $callback);
}