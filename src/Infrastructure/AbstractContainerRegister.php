<?php
namespace ImmediateSolutions\Infrastructure;
use Doctrine\ORM\EntityManagerInterface;
use ImmediateSolutions\Infrastructure\Doctrine\DoctrineConfigurationFactory;
use ImmediateSolutions\Infrastructure\Doctrine\DoctrineConnectionFactory;
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
                return new Config(require __DIR__.'/../../config/config.php');
            })

            ->service('doctrine:configuration', new DoctrineConfigurationFactory())
            ->service('doctrine:connection', DoctrineConnectionFactory::getFactoryByContainer())
            ->service(EntityManagerInterface::class, new EntityManagerFactory());
    }
}