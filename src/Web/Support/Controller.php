<?php
namespace ImmediateSolutions\Web\Support;
use ImmediateSolutions\Support\Framework\ContainerInterface;
use League\Plates\Engine;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class Controller
{
    /**
     * @var Engine
     */
    private $view;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var ServerRequestInterface
     */
    protected $request;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->request = $container->get(ServerRequestInterface::class);

        $this->view = new Engine(APP_PATH.'/views');

        if (method_exists($this, 'initialize')){
            $this->container->call([$this, 'initialize']);
        }
    }

    /**
     * @param $path
     * @param array $parameters
     * @return ResponseInterface
     */
    protected function show($path, array $parameters = [])
    {
        $response = new Response('php://memory', 200, [
            'Content-Type' => 'text/html'
        ]);
        $response->getBody()->write($this->view->render($path, $parameters));

        return $response;
    }
}