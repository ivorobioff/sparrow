<?php
namespace ImmediateSolutions\Api\Thing\Controllers\Permissions;
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
            'index' => 'all',
            'show' => 'all',
            'store' => 'all'
        ];
    }
}