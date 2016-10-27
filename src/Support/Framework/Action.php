<?php
namespace ImmediateSolutions\Support\Framework;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Action
{
    /**
     * @var array
     */
    private $arguments = [];

    /**
     * @var callable
     */
    private $callback;

    /**
     * @param callable $callback
     * @param array $arguments
     */
    public function __construct(callable $callback, array $arguments = [])
    {
        $this->callback = $callback;
        $this->arguments = $arguments;
    }
    /**
     * @return callable
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }
}