<?php
namespace ImmediateSolutions\Support\Framework;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DispatcherMiddleware implements MiddlewareInterface
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
     * @param ServerRequestInterface $request
     * @param callable $next
     * @return mixed
     */
    public function handle(ServerRequestInterface $request, callable $next = null)
    {
        /**
         * @var DispatcherInterface $dispatcher
         */
        $dispatcher = $this->container->get(DispatcherInterface::class);

        return $dispatcher->dispatch($request);
    }
}