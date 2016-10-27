<?php
namespace ImmediateSolutions\Support\Framework;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface CommandRegisterInterface
{
    /**
     * @param CommandStorageInterface $storage
     */
    public function register(CommandStorageInterface $storage);
}