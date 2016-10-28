<?php
namespace ImmediateSolutions\Infrastructure\Doctrine;
use ImmediateSolutions\Infrastructure\Doctrine\Metadata\SimpleDriver;
use ImmediateSolutions\Support\Framework\ContainerInterface;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\Tools\Setup;
use ImmediateSolutions\Infrastructure\Doctrine\Metadata\CompositeDriver;
use ImmediateSolutions\Infrastructure\Doctrine\Metadata\PackageDriver;
use DoctrineExtensions\Query\Mysql\Year as MysqlYear;
use DoctrineExtensions\Query\Sqlite\Year as SqliteYear;
use DoctrineExtensions\Query\Mysql\Month as MysqlMonth;
use DoctrineExtensions\Query\Sqlite\Month as SqliteMonth;
use RuntimeException;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DoctrineConfigurationFactory
{
    /**
     * @param  ContainerInterface $container
     * @return Configuration
     */
    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config')->get('doctrine', []);

        $setup = Setup::createConfiguration();

        $cache = new $config['cache']();

        $setup->setMetadataCacheImpl($cache);
        $setup->setQueryCacheImpl($cache);

        $setup->setProxyDir($config['proxy']['dir']);
        $setup->setProxyNamespace($config['proxy']['namespace']);
        $setup->setAutoGenerateProxyClasses(array_get($config, 'proxy.auto', false));

        $packages = $container->get('config')->get('packages');

        $setup->setMetadataDriverImpl(new CompositeDriver([
            new PackageDriver($packages),
            new SimpleDriver(array_get($config, 'entities', []))
        ]));

        $setup->setNamingStrategy(new UnderscoreNamingStrategy());
        $setup->setDefaultRepositoryClassName(DefaultRepository::class);


        $driver = $config['connections'][$config['db']]['driver'];

        if ($driver == 'pdo_sqlite'){
            $setup->addCustomDatetimeFunction('YEAR', SqliteYear::class);
            $setup->addCustomDatetimeFunction('MONTH', SqliteMonth::class);
        } else if ($driver == 'pdo_mysql'){
            $setup->addCustomDatetimeFunction('YEAR', MysqlYear::class);
            $setup->addCustomDatetimeFunction('MONTH', MysqlMonth::class);
        } else {
            throw new RuntimeException('Unable to add functions under unknown driver "'.$driver.'".');
        }


        return $setup;
    }
}