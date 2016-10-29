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
     * @return $this
     */
    public function get($pattern, $callback)
    {
        $this->collector->addRoute('GET', $pattern, $callback);
        return $this;
    }

    /**
     * @param string $pattern
     * @param callable|string $callback
     * @return $this
     */
    public function post($pattern, $callback)
    {
        $this->collector->addRoute('POST', $pattern, $callback);
        return $this;
    }

    /**
     * @param string $pattern
     * @param callable|string $callback
     * @return $this
     */
    public function put($pattern, $callback)
    {
        $this->collector->addRoute('PUT', $pattern, $callback);
        return $this;
    }

    /**
     * @param string $pattern
     * @param callable|string $callback
     * @return $this
     */
    public function delete($pattern, $callback)
    {
        $this->collector->addRoute('DELETE', $pattern, $callback);
        return $this;
    }

    /**
     * @param string $pattern
     * @param callable|string $callback
     * @return $this
     */
    public function patch($pattern, $callback)
    {
        $this->collector->addRoute('PATCH', $pattern, $callback);
        return $this;
    }
}