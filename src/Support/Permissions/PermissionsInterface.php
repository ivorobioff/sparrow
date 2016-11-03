<?php
namespace ImmediateSolutions\Support\Permissions;
use ImmediateSolutions\Support\Framework\Action;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface PermissionsInterface
{
    /**
     * @param string|array $protectors
     * @param Action $action
     * @return bool
     */
    public function has($protectors, Action $action);

    /**
     * @param array $protectors
     */
    public function globals(array $protectors);
}