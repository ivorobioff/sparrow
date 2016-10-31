<?php
namespace ImmediateSolutions\Infrastructure;
use ImmediateSolutions\Support\Framework\EnvironmentInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Environment implements EnvironmentInterface
{
    /**
     * @return bool
     */
    public function isDevelopment()
    {
        return true;
    }
}