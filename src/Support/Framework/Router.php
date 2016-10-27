<?php
namespace ImmediateSolutions\Support\Framework;
use FastRoute\RouteCollector;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Router implements RouterInterface
{
    /**
     * @var RouteCollector
     */
    private $collector;

    /**
     * @param RouteCollector $collector
     */
    public function __construct(RouteCollector $collector)
    {
        $this->collector = $collector;
    }

    /**
     * @param string $pattern
     * @param callable|string $callback
     */
    public function get($pattern, $callback)
    {
        $this->collector->addRoute('GET', $pattern, $callback);
    }

    /**
     * @param string $pattern
     * @param callable|string $callback
     */
    public function post($pattern, $callback)
    {
        $this->collector->addRoute('POST', $pattern, $callback);
    }

    /**
     * @param string $pattern
     * @param callable|string $callback
     */
    public function put($pattern, $callback)
    {
        $this->collector->addRoute('PUT', $pattern, $callback);
    }

    /**
     * @param string $pattern
     * @param callable|string $callback
     */
    public function delete($pattern, $callback)
    {
        $this->collector->addRoute('DELETE', $pattern, $callback);
    }

    /**
     * @param string $pattern
     * @param callable|string $callback
     */
    public function patch($pattern, $callback)
    {
        $this->collector->addRoute('PATCH', $pattern, $callback);
    }
}