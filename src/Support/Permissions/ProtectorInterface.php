<?php
namespace ImmediateSolutions\Support\Permissions;
use ImmediateSolutions\Support\Framework\Action;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface ProtectorInterface
{
    /**
     * @param Action $action
     * @return bool
     */
    public function grants(Action $action);
}