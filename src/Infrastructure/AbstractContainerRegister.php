<?php
namespace ImmediateSolutions\Infrastructure;
use Doctrine\ORM\EntityManagerInterface;
use ImmediateSolutions\Infrastructure\Doctrine\EntityManagerFactory;
use ImmediateSolutions\Support\Framework\ContainerPopulatorInterface;
use ImmediateSolutions\Support\Framework\ContainerRegisterInterface;
use ImmediateSolutions\Support\Api\JsonResponseFactory;
use ImmediateSolutions\Support\Api\ResponseFactoryInterface;
use ImmediateSolutions\Support\Framework\EnvironmentInterface;
use Psr\Log\LoggerInterface;

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
            ->service(ConfigInterface::class, function(){
                return new Config(require  APP_PATH.'/config/config.php');
            })
            ->instance(ResponseFactoryInterface::class, JsonResponseFactory::class)
            ->service(EntityManagerInterface::class, new EntityManagerFactory())
            ->service(EnvironmentInterface::class, Environment::class)
            ->service(LoggerInterface::class, new MonologLoggerFactory());
    }
}