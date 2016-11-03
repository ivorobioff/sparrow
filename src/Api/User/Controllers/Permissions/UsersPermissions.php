<?php
namespace ImmediateSolutions\Api\User\Controllers\Permissions;
use ImmediateSolutions\Api\User\Protectors\OwnerProtector;
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
            'update' => OwnerProtector::class,
            'destroy' => OwnerProtector::class,
            'show' => OwnerProtector::class
        ];
    }
}