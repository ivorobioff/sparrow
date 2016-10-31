<?php
namespace ImmediateSolutions\Api\Support;
use ImmediateSolutions\Infrastructure\AbstractContainerRegister;
use ImmediateSolutions\Infrastructure\ConfigInterface;
use ImmediateSolutions\Support\Framework\ActionMiddlewareRegisterInterface;
use ImmediateSolutions\Support\Framework\ContainerInterface;
use ImmediateSolutions\Support\Framework\ContainerPopulatorInterface;
use ImmediateSolutions\Support\Framework\MiddlewareRegisterInterface;
use ImmediateSolutions\Support\Framework\RouteRegisterInterface;
use ImmediateSolutions\Support\Api\AbstractProcessor;
use ImmediateSolutions\Support\Permissions\Permissions;
use ImmediateSolutions\Support\Permissions\PermissionsInterface;

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
            ->instance(RouteRegisterInterface::class, RouteRegister::class)
            ->instance(MiddlewareRegisterInterface::class, MiddlewareRegister::class)
            ->instance(ActionMiddlewareRegisterInterface::class, ActionMiddlewareRegister::class)

            ->service(PermissionsInterface::class, function(ContainerInterface $container){
                $permissions =  new Permissions($container);

                /**
                 * @var ConfigInterface $config
                 */
                $config = $container->get(ConfigInterface::class);

                $permissions->globals($config->get('protectors', []));

                return $permissions;
            })

            ->initialize(AbstractProcessor::class, function(AbstractProcessor $processor){
                $processor->validate();
            });
    }
}