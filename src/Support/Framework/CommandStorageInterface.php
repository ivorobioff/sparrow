<?php
namespace ImmediateSolutions\Support\Framework;
use Symfony\Component\Console\Command\Command;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface CommandStorageInterface
{
    /**
     * @param Command|string|callable $command
     * @return $this
     */
    public function add($command);
}