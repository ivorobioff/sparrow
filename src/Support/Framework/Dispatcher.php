<?php
namespace ImmediateSolutions\Support\Framework;

use ImmediateSolutions\Support\Framework\Exceptions\MethodNotAllowedHttpException;
use ImmediateSolutions\Support\Framework\Exceptions\NotFoundHttpException;
use Psr\Http\Message\RequestInterface;
use FastRoute\RouteCollector as FastRouteCollector;
use FastRoute\RouteParser\Std as FastParser;
use FastRoute\DataGenerator\GroupCountBased as FastGenerator;
use FastRoute\Dispatcher\GroupCountBased as FastDispatcher;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Dispatcher implements DispatcherInterface
{
    /**
     * @var ContainerInterface $container
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
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function dispatch(RequestInterface $request)
    {
        $parser = new FastParser();
        $generator = new FastGenerator();

        $collector = new FastRouteCollector($parser, $generator);

        $router = new Router($collector);

        if ($this->container->has(RouteRegisterInterface::class)){
            /**
             * @var RouteRegisterInterface $routeRegister
             */
            $routeRegister = $this->container->get(RouteRegisterInterface::class);
            $routeRegister->register($router);
        }

        $dispatcher = new FastDispatcher($collector->getData());

        $result = $dispatcher->dispatch($request->getMethod(), $request->getUri()->getPath());

        if ($result[0] == FastDispatcher::NOT_FOUND){
            throw new NotFoundHttpException();
        }

        if ($result[0] == FastDispatcher::METHOD_NOT_ALLOWED){
            throw new MethodNotAllowedHttpException();
        }

        $action = $result[1];
        $arguments = $result[2];

        if (!is_callable($action)){
            list($controller, $method) = explode('@', $action);

            if (!class_exists($controller)){
                throw new NotFoundHttpException();
            }

            $controller = $this->container->get($controller);

            if (!method_exists($controller, $method)){
                throw new MethodNotAllowedHttpException();
            }

            $action = [$controller, $method];
        }

        return $this->container->call($action, $arguments);
    }
}