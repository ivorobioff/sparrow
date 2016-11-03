<?php
namespace ImmediateSolutions\Api\Session\Controllers\Permissions;
use ImmediateSolutions\Api\Session\Protectors\OwnerProtector;
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
            'show' => OwnerProtector::class,
            'destroy' => OwnerProtector::class,
            'refresh' => OwnerProtector::class
        ];
    }
}