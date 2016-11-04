<?php
namespace ImmediateSolutions\Support\Framework;

use ImmediateSolutions\Support\Framework\Exceptions\MethodNotAllowedHttpException;
use ImmediateSolutions\Support\Framework\Exceptions\NotFoundHttpException;
use Psr\Http\Message\ServerRequestInterface;
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
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function dispatch(ServerRequestInterface $request)
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

        if (!is_callable($result[1])){
            list($controller, $method) = explode('@', $result[1]);

            if (!class_exists($controller)){
                throw new NotFoundHttpException();
            }

            $controller = $this->container->get($controller);

            if (!method_exists($controller, $method)){
                throw new MethodNotAllowedHttpException();
            }

            $action = new Action([$controller, $method], $result[2]);
        } else {
            $action = new Action($result[1], $result[2]);
        }

        $action->setRequest($request);

        $pipeline = new MiddlewarePipeline($this->container);

        if ($this->container->has(ActionMiddlewareRegisterInterface::class)){

            /**
             * @var ActionMiddlewareRegisterInterface $middlewareRegister
             */
            $middlewareRegister = $this->container->get(ActionMiddlewareRegisterInterface::class);

            $middlewareRegister->register($pipeline);
        }

        $pipeline->add(ActionMiddleware::class);

        return $pipeline->handle($action);
    }
}