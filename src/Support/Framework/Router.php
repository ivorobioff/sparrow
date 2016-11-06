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
     * @var string
     */
    private $namespace = '';

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
        $this->collector->addRoute('GET', $this->namespace.$pattern, $callback);
        return $this;
    }

    /**
     * @param string $pattern
     * @param callable|string $callback
     * @return $this
     */
    public function post($pattern, $callback)
    {
        $this->collector->addRoute('POST', $this->namespace.$pattern, $callback);
        return $this;
    }

    /**
     * @param string $pattern
     * @param callable|string $callback
     * @return $this
     */
    public function put($pattern, $callback)
    {
        $this->collector->addRoute('PUT', $this->namespace.$pattern, $callback);
        return $this;
    }

    /**
     * @param string $pattern
     * @param callable|string $callback
     * @return $this
     */
    public function delete($pattern, $callback)
    {
        $this->collector->addRoute('DELETE', $this->namespace.$pattern, $callback);
        return $this;
    }

    /**
     * @param string $pattern
     * @param callable|string $callback
     * @return $this
     */
    public function patch($pattern, $callback)
    {
        $this->collector->addRoute('PATCH', $this->namespace.$pattern, $callback);
        return $this;
    }

    /**
     * @param string $namespace
     * @param callable $callback
     * @return $this
     */
    public function group($namespace, callable $callback)
    {
        $this->namespace = $namespace;

        $callback($this);

        $this->namespace = '';

        return $this;
    }
}