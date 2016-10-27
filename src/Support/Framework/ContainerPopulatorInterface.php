<?php
namespace ImmediateSolutions\Support\Framework;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface ContainerPopulatorInterface
{
    /**
     * @param string $target
     * @param callable|string $source
     * @return $this
     */
    public function service($target, $source);

    /**
     * @param string $target
     * @param string|callable $source
     * @return $this
     */
    public function instance($target, $source);

    /**
     * @param string $target
     * @param object $instance
     * @return $this
     */
    public function alias($target, $instance);

    /**
     * @param string $target
     * @param callable $initializer
     * @return $this
     */
    public function initialize($target, callable $initializer);
}