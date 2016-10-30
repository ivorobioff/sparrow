<?php
namespace ImmediateSolutions\Support\Core\Service;

use Doctrine\ORM\EntityManagerInterface;
use ImmediateSolutions\Support\Framework\ContainerInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class AbstractService
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->entityManager = $container->get(EntityManagerInterface::class);

        if (method_exists($this, 'initialize')) {
            $this->container->call([$this, 'initialize']);
        }
    }
}