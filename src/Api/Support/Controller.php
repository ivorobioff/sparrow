<?php
namespace ImmediateSolutions\Api\Support;
use ImmediateSolutions\Core\Session\Entities\Session;
use ImmediateSolutions\Support\Api\AbstractController;
use ImmediateSolutions\Support\Framework\ContainerInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class Controller extends AbstractController
{
    /**
     * @var Session
     */
    protected $session;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);

        $this->session = $container->get(Session::class);
    }
}