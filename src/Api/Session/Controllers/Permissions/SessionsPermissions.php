<?php
namespace ImmediateSolutions\Api\Session\Controllers\Permissions;
use ImmediateSolutions\Support\Permissions\AbstractActionsPermissions;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class SessionsPermissions extends AbstractActionsPermissions
{
    /**
     * @return array
     */
    protected function permissions()
    {
        return [
            'store' => 'all',
            'show' => 'owner',
            'destroy' => 'owner',
            'refresh' => 'owner'
        ];
    }
}