<?php
namespace ImmediateSolutions\Infrastructure\Doctrine;

use Doctrine\Common\EventManager;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\Configuration;
use ImmediateSolutions\Support\Framework\ContainerInterface;
use Closure;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DoctrineConnectionFactory
{
    /**
     * @return Closure
     */
    public static function getFactoryByParameters()
    {
        return function (array $dbConfig, Configuration $configuration){
            return DriverManager::getConnection($dbConfig, $configuration, new EventManager());
        };
    }

    /**
     * @return Closure
     */
    public static function getFactoryByContainer()
    {
        return function (ContainerInterface $container){
            /**
             * @var Configuration $configuration
             */
            $configuration = $container->get('doctrine:configuration');

            $factory = self::getFactoryByParameters();

            $settings = $container->get('config')->get('doctrine', []);
            $dbConfig = $settings['connections'][$settings['db']];

            return $factory($dbConfig, $configuration);
        };
    }
}