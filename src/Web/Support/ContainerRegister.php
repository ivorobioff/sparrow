<?php
namespace ImmediateSolutions\Web\Support;
use ImmediateSolutions\Infrastructure\AbstractContainerRegister;
use ImmediateSolutions\Support\Framework\ContainerPopulatorInterface;
use ImmediateSolutions\Support\Framework\RouteRegisterInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ContainerRegister extends AbstractContainerRegister
{
    /**
     * @param ContainerPopulatorInterface $populator
     */
    public function register(ContainerPopulatorInterface $populator)
    {
        parent::register($populator);

        $populator->instance(RouteRegisterInterface::class, RouteRegister::class);
    }
}