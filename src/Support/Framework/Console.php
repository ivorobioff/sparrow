<?php
namespace ImmediateSolutions\Support\Framework;
use Symfony\Component\Console\Application as CLI;
use Symfony\Component\Console\Command\Command;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Console implements CommandStorageInterface
{
    /**
     * @var ContainerRegisterInterface
     */
    private $containerRegister;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var Command[]
     */
    private $commands = [];


    /**
     * @param ContainerRegisterInterface $register
     */
    public function __construct(ContainerRegisterInterface $register)
    {
        $this->containerRegister = $register;
    }

    public function run()
    {
        $this->container = new Container();
        $this->container->alias(ContainerInterface::class, $this->container);

        $this->containerRegister->register($this->container);

        if ($this->container->has(CommandRegisterInterface::class)){

            /**
             * @var CommandRegisterInterface $commandRegister
             */
            $commandRegister = $this->container->get(CommandRegisterInterface::class);

            $commandRegister->register($this);
        }

        $cli = new CLI();

        foreach ($this->commands as $command){
            $cli->add($this->resolveCommand($command));
        }

        $cli->run();
    }

    /**
     * @param Command|string|callable $command
     * @return Command
     */
    private function resolveCommand($command)
    {
        if ($command instanceof Command){
            return $command;
        }

        if (is_callable($command)){
            return $command();
        }

        return $this->container->get($command);
    }

    /**
     * @param Command|string|callable $command
     * @return $this
     */
    public function add($command)
    {
        $this->commands[] = $command;
        return $this;
    }
}