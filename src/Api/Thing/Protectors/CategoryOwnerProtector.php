<?php
namespace ImmediateSolutions\Api\Thing\Protectors;
use ImmediateSolutions\Api\Support\Protectors\AbstractOwnerProtector;
use ImmediateSolutions\Core\User\Services\UserService;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CategoryOwnerProtector extends AbstractOwnerProtector
{
    /**
     * @param int $id
     * @return bool
     */
    protected function isOwner($id)
    {
        /**
         * @var UserService $userService
         */
        $userService = $this->container->get(UserService::class);

        return $userService->hasCategory($this->session->getUser()->getId(), $id);
    }
}