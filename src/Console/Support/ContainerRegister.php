<?php
namespace ImmediateSolutions\Console\Support;
use ImmediateSolutions\Infrastructure\AbstractContainerRegister;
use ImmediateSolutions\Support\Framework\CommandRegisterInterface;
use ImmediateSolutions\Support\Framework\ContainerPopulatorInterface;

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

        $populator
            ->instance(CommandRegisterInterface::class, CommandRegister::class);
    }
}