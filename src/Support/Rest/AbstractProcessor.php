<?php
namespace ImmediateSolutions\Support\Rest;
use ImmediateSolutions\Support\Framework\ContainerInterface;
use Psr\Http\Message\RequestInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class AbstractProcessor
{
    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var array
     */
    private $data;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->request = $container->get(RequestInterface::class);
    }

    /**
     * @param string $path
     * @param mixed $default
     * @return mixed
     */
    protected function get($path, $default = null)
    {
        if ($this->data === null){
            $data = $this->request->getBody()->getContents();

            $data = json_decode($data, true);

            if ($data === null){
                $this->data = [];
            }
        }

        return array_get($this->data, $path, $default);
    }
}