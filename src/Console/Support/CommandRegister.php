<?php
namespace ImmediateSolutions\Console\Support;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use ImmediateSolutions\Support\Framework\CommandRegisterInterface;
use ImmediateSolutions\Support\Framework\CommandStorageInterface;
use ImmediateSolutions\Support\Framework\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\HelperSet;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CommandRegister implements CommandRegisterInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param CommandStorageInterface $storage
     */
    public function register(CommandStorageInterface $storage)
    {
        $storage->add($this->withinDoctrine(new UpdateCommand()));
    }

    /**
     * @param Command $command
     * @return Command
     */
    private function withinDoctrine(Command $command)
    {
        $command->setHelperSet(new HelperSet([
            'em' => new EntityManagerHelper($this->container->get(EntityManagerInterface::class))
        ]));

        return $command;
    }
}