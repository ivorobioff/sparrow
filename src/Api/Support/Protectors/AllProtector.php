<?php
namespace ImmediateSolutions\Api\Support\Protectors;
use ImmediateSolutions\Support\Framework\Action;
use ImmediateSolutions\Support\Permissions\ProtectorInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AllProtector implements ProtectorInterface
{
    /**
     * @param Action $action
     * @return bool
     */
    public function grants(Action $action)
    {
        return true;
    }
}