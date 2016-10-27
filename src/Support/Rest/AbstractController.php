<?php
namespace ImmediateSolutions\Support\Rest;
use ImmediateSolutions\Support\Framework\ContainerInterface;
use ImmediateSolutions\Support\Rest\Kangaroo\Reply;

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
     * @param string $class
     * @return callable
     */
    public function serializer($class)
    {
        return $this->container->get($class);
    }
}