<?php
namespace ImmediateSolutions\Core\Session\Interfaces;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface SessionPreferenceInterface
{
    /**
     * @return int
     */
    public function getLifeTime();
}