<?php
namespace ImmediateSolutions\Console\Support;

use Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand;
use ImmediateSolutions\Support\Framework\CommandRegisterInterface;
use ImmediateSolutions\Support\Framework\CommandStorageInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CommandRegister implements CommandRegisterInterface
{
    /**
     * @param CommandStorageInterface $storage
     */
    public function register(CommandStorageInterface $storage)
    {
        $storage
            ->add(new CreateCommand())
            ->add(new UpdateCommand());
    }
}