<?php
namespace ImmediateSolutions\Infrastructure;
use ImmediateSolutions\Core\Session\Interfaces\SessionPreferenceInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class SessionPreference implements SessionPreferenceInterface
{
    /**
     * @return int
     */
    public function getLifeTime()
    {
        return 1440;
    }
}