<?php
namespace ImmediateSolutions\Api\Session\Serializers;
use ImmediateSolutions\Api\Support\Serializer;
use ImmediateSolutions\Api\User\Serializers\UserSerializer;
use ImmediateSolutions\Core\Session\Entities\Session;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class SessionSerializer extends Serializer
{
    /**
     * @param Session $session
     * @return array
     */
    public function __invoke(Session $session)
    {
        return [
            'id' => $session->getId(),
            'token' => $session->getToken(),
            'user' => $this->delegate(UserSerializer::class, $session->getUser()),
            'createdAt' => $this->datetime($session->getCreatedAt()),
            'expiresAt' => $this->datetime($session->getExpiresAt())
        ];
    }
}