<?php
namespace ImmediateSolutions\Api\Support;

use DateTime;
use ImmediateSolutions\Support\Framework\ContainerInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class Serializer
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param $serializer
     * @param $object
     */
    protected function delegate($serializer, $object)
    {
        $serializer = $this->container->get($serializer);

        return $serializer($object);
    }

    /**
     * @param DateTime $datetime
     * @return string
     */
    protected function datetime(DateTime $datetime)
    {
        return $datetime->format(DateTime::ATOM);
    }
}