<?php
namespace ImmediateSolutions\Api\User\Protectors;
use ImmediateSolutions\Api\Support\Protectors\AbstractOwnerProtector;

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
        return (int)$this->session->getUser()->getId() === (int) $id;
    }
}