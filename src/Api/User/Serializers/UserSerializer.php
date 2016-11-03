<?php
namespace ImmediateSolutions\Api\User\Serializers;
use ImmediateSolutions\Api\Support\Serializer;
use ImmediateSolutions\Core\User\Entities\User;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class UserSerializer extends Serializer
{
    public function __invoke(User $user)
    {
        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'createdAt' => $this->datetime($user->getCreatedAt())
        ];
    }
}