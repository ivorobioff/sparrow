<?php
namespace ImmediateSolutions\Api\Thing\Controllers\Permissions;
use ImmediateSolutions\Api\Thing\Protectors\ThingOwnerProtector;
use ImmediateSolutions\Support\Permissions\AbstractActionsPermissions;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ThingsPermissions extends AbstractActionsPermissions
{
    /**
     * @return array
     */
    protected function permissions()
    {
        return [
            'index' => 'auth',
            'store' => 'auth',
            'show' => ThingOwnerProtector::class,
            'destroy' => ThingOwnerProtector::class,
            'update' => ThingOwnerProtector::class
        ];
    }
}