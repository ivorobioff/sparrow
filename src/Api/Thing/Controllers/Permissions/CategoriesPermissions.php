<?php
namespace ImmediateSolutions\Api\Thing\Controllers\Permissions;
use ImmediateSolutions\Api\Thing\Protectors\CategoryOwnerProtector;
use ImmediateSolutions\Support\Permissions\AbstractActionsPermissions;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CategoriesPermissions extends AbstractActionsPermissions
{
    /**
     * @return array
     */
    protected function permissions()
    {
        return [
            'index' => 'auth',
            'store' => 'auth',
            'show' => CategoryOwnerProtector::class,
            'update' => CategoryOwnerProtector::class,
            'destroy' => CategoryOwnerProtector::class
        ];
    }
}