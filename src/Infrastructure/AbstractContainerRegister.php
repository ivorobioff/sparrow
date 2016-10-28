<?php
namespace ImmediateSolutions\Infrastructure;
use Doctrine\ORM\EntityManagerInterface;
use ImmediateSolutions\Infrastructure\Doctrine\EntityManagerFactory;
use ImmediateSolutions\Support\Framework\ContainerPopulatorInterface;
use ImmediateSolutions\Support\Framework\ContainerRegisterInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class AbstractContainerRegister implements ContainerRegisterInterface
{
    /**
     * @param ContainerPopulatorInterface $populator
     */
    public function register(ContainerPopulatorInterface $populator)
    {
        $populator
            ->service('config', function(){
                return new Config(APP_PATH.'/config/config.php');
            })
            ->service(EntityManagerInterface::class, new EntityManagerFactory());
    }
}