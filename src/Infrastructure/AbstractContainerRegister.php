<?php
namespace ImmediateSolutions\Infrastructure;
use Doctrine\ORM\EntityManagerInterface;
use ImmediateSolutions\Infrastructure\Doctrine\EntityManagerFactory;
use ImmediateSolutions\Support\Framework\ContainerPopulatorInterface;
use ImmediateSolutions\Support\Framework\ContainerRegisterInterface;
use ImmediateSolutions\Support\Rest\JsonResponseFactory;
use ImmediateSolutions\Support\Rest\ResponseFactoryInterface;
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
            ->service('config', function(){
                return new Config(require  APP_PATH.'/config/config.php');
            })
            ->instance(ResponseFactoryInterface::class, JsonResponseFactory::class)
            ->service(EntityManagerInterface::class, new EntityManagerFactory())
            ->service(LoggerInterface::class, new MonologLoggerFactory());
    }
}