<?php
namespace ImmediateSolutions\Support\Framework;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class MiddlewareProcessor
{
    /**
     * @var ContainerInterface
     */
    private $container;

    private $middlewares = [];

    public function __construct(ContainerInterface $container)
    {
        $this->container;
    }

    /**
     * @param MiddlewareInterface $middleware
     * @return $this
     */
    public function register(MiddlewareInterface $middleware)
    {
        $this->middlewares[] = $middleware;

        return $this;
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     */
    public function process(RequestInterface $request, ResponseInterface $response)
    {
        $middlewares = array_reverse($this->middlewares);


    }
}