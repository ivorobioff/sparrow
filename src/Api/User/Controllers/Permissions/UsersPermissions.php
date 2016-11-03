<?php
namespace ImmediateSolutions\Api\User\Controllers\Permissions;
use ImmediateSolutions\Support\Permissions\AbstractActionsPermissions;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class UsersPermissions extends AbstractActionsPermissions
{
    /**
     * @return array
     */
    protected function permissions()
    {
        return [
            'store' => 'all',
            'update' => 'owner',
            'destroy' => 'owner',
            'show' => 'owner'
        ];
    }
}