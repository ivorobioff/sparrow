<?php
namespace ImmediateSolutions\Support\Framework;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface EnvironmentInterface
{
    /**
     * @return bool
     */
    public function isDevelopment();
}