<?php
namespace ImmediateSolutions\Infrastructure;
use Doctrine\ORM\EntityManagerInterface;
use ImmediateSolutions\Core\Document\Interfaces\DocumentPreferenceInterface;
use ImmediateSolutions\Core\Document\Interfaces\StorageInterface;
use ImmediateSolutions\Core\Session\Interfaces\SessionPreferenceInterface;
use ImmediateSolutions\Support\Core\Interfaces\TokenGeneratorInterface;
use ImmediateSolutions\Core\User\Interfaces\PasswordEncryptorInterface;
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
            ->service(PasswordEncryptorInterface::class, PasswordEncryptor::class)
            ->service(TokenGeneratorInterface::class, TokenGenerator::class)
            ->service(StorageInterface::class, Storage::class)
            ->service(SessionPreferenceInterface::class, SessionPreference::class)
            ->service(DocumentPreferenceInterface::class, DocumentPreference::class)
            ->service(LoggerInterface::class, new MonologLoggerFactory());
    }
}