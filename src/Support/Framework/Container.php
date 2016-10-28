<?php
namespace ImmediateSolutions\Support\Framework;

use Illuminate\Container\Container as Laravel;
use Closure;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Container implements ContainerPopulatorInterface, ContainerInterface
{
    /**
     * @var Laravel
     */
    private $laravel;

    public function __construct()
    {
        $this->laravel = new Laravel();
    }

    /**
     * @param string $target
     * @param callable|string $source
     * @return $this
     */
    public function service($target, $source)
    {
        $this->laravel->singleton($target, $this->protectSource($source));
        return $this;
    }

    /**
     * @param string $target
     * @param string|callable $source
     * @return $this
     */
    public function instance($target, $source)
    {
        $this->laravel->bind($target, $this->protectSource($source));
        return $this;
    }

    /**
     * @param string $target
     * @param object $instance
     * @return $this
     */
    public function alias($target, $instance)
    {
        $this->laravel->instance($target, $instance);
        return $this;
    }

    /**
     * @param string $target
     * @param callable $initializer
     * @return $this
     */
    public function initialize($target, callable $initializer)
    {
        $this->laravel->resolving($target, function($instance) use ($initializer){
            $initializer($instance, $this);
        });

        return $this;
    }

    /**
     * @param string|callable $source
     * @return Closure
     */
    private function protectSource($source)
    {
        if (is_callable($source)){
            return function() use ($source){
                return $source($this);
            };
        }

        return $source;
    }

    /**
     * @param string $id
     * @return bool
     */
    public function get($id)
    {
        return $this->laravel->make($id);
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has($id)
    {
        return $this->laravel->bound($id);
    }

    /**
     * @param callable $callback
     * @param array $arguments
     * @return mixed
     */
    public function call(callable $callback, array $arguments = [])
    {
        return $this->laravel->call($callback, $arguments);
    }
}