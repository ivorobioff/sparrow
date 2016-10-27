<?php
namespace ImmediateSolutions\Support\Framework;
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
     * @param  mixed $context
     * @return ResponseInterface
     */
    public function handle($context)
    {
        $middlewares = array_reverse($this->middlewares);

        $first = array_shift($middlewares);

        $first = function($context) use ($first){
            return $this->resolveMiddleware($first)
                ->handle($context, function(){});
        };

        $onion = array_reduce($middlewares, function(callable $carry, $middleware){
                return function($context) use ($carry, $middleware){
                    return $this->resolveMiddleware($middleware)->handle($context, $carry);
                };
        }, $first);

        return $onion($context);
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