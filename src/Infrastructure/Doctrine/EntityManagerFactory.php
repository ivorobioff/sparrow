<?php
namespace ImmediateSolutions\Infrastructure\Doctrine;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use ImmediateSolutions\Support\Framework\ContainerInterface;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\Configuration;
use Doctrine\DBAL\Types\Type;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;


/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class EntityManagerFactory
{
    /**
     * @param ContainerInterface $container
     * @return EntityManagerInterface
     */
    public function __invoke(ContainerInterface $container)
    {
        /**
         * @var Connection $connection
         */
        $connection = $container->get('doctrine:connection');

        /**
         * @var Configuration $configuration
         */
        $configuration = $container->get('doctrine:configuration');

        return $this->createEntityManager($connection, $configuration, $container);
    }

    /**
     *
     * @param Connection $connection
     * @param Configuration $configuration
     * @param ContainerInterface $container
     * @return EntityManagerInterface
     */
    private function createEntityManager(Connection $connection, Configuration $configuration, ContainerInterface $container)
    {
        $packages = $container->get('config')->get('packages');

        $em = EntityManager::create($connection, $configuration);

        $this->registerTypes($em->getConnection(), $packages, $container->get('config')->get('doctrine.types', []));

        return $em;
    }

    /**
     *
     * @param Connection $connection
     * @param array $packages
     * @param array $extra
     */
    private function registerTypes(Connection $connection, array $packages, array $extra = [])
    {
        foreach ($packages as $package) {
            $path = APP_PATH.'/src/Infrastructure/DAL/' . str_replace('\\', '/', $package) . '/Types';
            $typeNamespace = 'ImmediateSolutions\Infrastructure\DAL\\' . $package . '\Types';

            if (! file_exists($path)) {
                continue;
            }

            $finder = new Finder();

            /**
             *
             * @var SplFileInfo[] $files
             */
            $files = $finder->in($path)
                ->files()
                ->name('*.php');

            foreach ($files as $file) {
                $name = cut_string_right($file->getFilename(), '.php');

                $typeClass = $typeNamespace . '\\' . $name;

                if (! class_exists($typeClass)) {
                    continue;
                }

                if (Type::hasType($typeClass)) {
                    Type::overrideType($typeClass, $typeClass);
                } else {
                    Type::addType($typeClass, $typeClass);
                }

                $connection->getDatabasePlatform()->registerDoctrineTypeMapping($typeClass, $typeClass);
            }
        }

        foreach ($extra as $type){
            if (Type::hasType($type)) {
                Type::overrideType($type, $type);
            } else {
                Type::addType($type, $type);
            }
        }
    }
}