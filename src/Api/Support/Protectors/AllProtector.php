<?php
namespace ImmediateSolutions\Api\Support\Protectors;
use ImmediateSolutions\Support\Permissions\ProtectorInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AllProtector implements ProtectorInterface
{
    /**
     * @return bool
     */
    public function grants()
    {
        return true;
    }
}