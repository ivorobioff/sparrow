<?php
namespace ImmediateSolutions\Support\Framework;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response\SapiEmitter;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Application implements MiddlewareInterface
{
    /**
     * @var ContainerRegisterInterface
     */
    private $containerRegister;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerRegisterInterface $register
     */
    public function __construct(ContainerRegisterInterface $register)
    {
        $this->containerRegister = $register;
    }

    public function run()
    {
        $this->container = new Container();

        $this->container->initialize(ContainerAwareInterface::class,
            function(ContainerAwareInterface $instance, ContainerInterface $container){
                $instance->setContainer($container);
            });

        $this->containerRegister->register($this->container);

        $middlewareProcessor = new MiddlewareProcessor($this->container);

        if ($this->container->has(MiddlewareRegisterInterface::class)){

            /**
             * @var MiddlewareRegisterInterface $middlewareRegister
             */
            $middlewareRegister = $this->container->get(MiddlewareRegisterInterface::class);

            $middlewareRegister->register($middlewareProcessor);
        }

        $middlewareProcessor->register($this);

        $request = ServerRequestFactory::fromGlobals();
        $response = new Response();

        $middlewareProcessor->process($request, $response);

        $emitter = new SapiEmitter();
        $emitter->emit($response);
    }


    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     * @return mixed
     */
    public function __invoke(RequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        if (!$next){
            return $response;
        }
    }
}