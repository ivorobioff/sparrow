<?php
namespace ImmediateSolutions\Support\Framework;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ActionMiddleware implements ActionMiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param Action $action
     * @param callable $next
     * @return ResponseInterface
     */
    public function handle(Action $action, callable $next)
    {
        return $this->container->call($action->getCallback(), $action->getArguments());
    }
}