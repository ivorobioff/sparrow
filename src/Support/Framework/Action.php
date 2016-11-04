<?php
namespace ImmediateSolutions\Support\Framework;
use Psr\Http\Message\ServerRequestInterface;

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
     * @var ServerRequestInterface
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
     * @param ServerRequestInterface $request
     */
    public function setRequest(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @return ServerRequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return object
     */
    public function getController()
    {
        if (!is_array($this->callback)){
            return null;
        }

        return $this->callback[0];
    }

    /**
     * @return null
     */
    public function getName()
    {
        if (!is_array($this->callback)){
            return null;
        }

        return $this->callback[1];
    }

    /**
     * @param string|string[] $names
     * @return bool
     */
    public function is($names)
    {
        if (!is_array($names)){
            $names = [$names];
        }

        return in_array($this->getName(), $names);
    }
}