<?php
namespace ImmediateSolutions\Api\Support\Protectors;
use ImmediateSolutions\Core\Session\Entities\Session;
use ImmediateSolutions\Support\Framework\Action;
use ImmediateSolutions\Support\Framework\ContainerInterface;
use ImmediateSolutions\Support\Permissions\ProtectorInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AuthProtector implements ProtectorInterface
{
    /**
     * @var Session
     */
    protected $session;

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
        $this->session = $container->get(Session::class);
    }

    /**
     * @param Action $action
     * @return bool
     */
    public function grants(Action $action)
    {
        return $this->session->getId() !== null;
    }
}