<?php
namespace ImmediateSolutions\Api\Thing\Controllers\Permissions;
use ImmediateSolutions\Api\Thing\Protectors\LocationOwnerProtector;
use ImmediateSolutions\Support\Permissions\AbstractActionsPermissions;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class LocationsPermissions extends AbstractActionsPermissions
{
    /**
     * @return array
     */
    protected function permissions()
    {
        return [
            'index' => 'auth',
            'store' => 'auth',
            'update' => LocationOwnerProtector::class,
            'show' => LocationOwnerProtector::class,
            'destroy' => LocationOwnerProtector::class
        ];
    }
}