<?php
namespace ImmediateSolutions\Support\Framework;
use Psr\Http\Message\RequestInterface;

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
     * @var RequestInterface
     */
    private $request;

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

    /**
     * @param RequestInterface $request
     */
    public function setRequest(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }
}