<?php
namespace ImmediateSolutions\Api\Session\Protectors;
use ImmediateSolutions\Api\Support\Protectors\AbstractOwnerProtector;
use ImmediateSolutions\Core\Session\Services\SessionService;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class OwnerProtector extends AbstractOwnerProtector
{
    /**
     * @param int $id
     * @return bool
     */
    protected function isOwner($id)
    {
        /**
         * @var SessionService $sessionService
         */
        $sessionService = $this->container->get(SessionService::class);

        $session = $sessionService->get($id);

        if (!$session){
            return false;
        }

        return (int) $this->session->getUser()->getId() === (int) $session->getUser()->getId();
    }
}