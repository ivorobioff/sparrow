<?php
namespace ImmediateSolutions\Support\Framework;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class MiddlewarePipeline
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var MiddlewareInterface[]
     */
    private $middlewares = [];

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param string|MiddlewareInterface|callable $middleware
     * @return $this
     */
    public function add($middleware)
    {
        $this->middlewares[] = $middleware;

        return $this;
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function handle(RequestInterface $request)
    {
        $middlewares = array_reverse($this->middlewares);

        $first = array_shift($middlewares);

        $first = function(RequestInterface $request) use ($first){
            return $this->resolveMiddleware($first)
                ->handle($request, function(){});
        };

        $onion = array_reduce($middlewares, function(callable $carry, $middleware){
                return function(RequestInterface $request) use ($carry, $middleware){
                    return $this->resolveMiddleware($middleware)->handle($request, $carry);
                };
        }, $first);

        return $onion($request);
    }

    /**
     * @param $middleware
     * @return MiddlewareInterface
     */
    private function resolveMiddleware($middleware)
    {
        if ($middleware instanceof MiddlewareInterface){
            return $middleware;
        }

        if (is_callable($middleware)){
            return $middleware();
        }

        return $this->container->get($middleware);
    }
}