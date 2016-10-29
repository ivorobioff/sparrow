<?php
namespace ImmediateSolutions\Support\Rest;
use ImmediateSolutions\Support\Framework\ContainerInterface;
use ImmediateSolutions\Support\Pagination\AdapterInterface;
use ImmediateSolutions\Support\Pagination\Describer;
use ImmediateSolutions\Support\Pagination\PaginationProviderInterface;
use ImmediateSolutions\Support\Pagination\Paginator;
use Psr\Http\Message\RequestInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class AbstractController
{
    /**
     * @var Reply
     */
    protected $reply;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->reply = $container->get(Reply::class);
        $this->request = $container->get(RequestInterface::class);
    }

    /**
     * @param AdapterInterface $adapter
     * @return object[]|PaginationProviderInterface
     */
    public function paginator(AdapterInterface $adapter)
    {
        return new Paginator($adapter, new Describer($this->request));
    }

    /**
     * @param string $class
     * @return callable
     */
    public function serializer($class)
    {
        return $this->container->get($class);
    }
}