<?php
namespace ImmediateSolutions\Core\Thing\Validation\Rules;
use ImmediateSolutions\Core\User\Entities\User;
use ImmediateSolutions\Core\User\Services\UserService;
use ImmediateSolutions\Support\Validation\Error;
use ImmediateSolutions\Support\Validation\Rules\AbstractRule;
use ImmediateSolutions\Support\Validation\Value;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class OwnLocation extends AbstractRule
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var User
     */
    private $owner;

    /**
     * @param UserService $userService
     * @param User $owner
     */
    public function __construct(UserService $userService, User $owner)
    {
        $this->userService = $userService;
        $this->owner = $owner;

        $this
            ->setIdentifier('permission')
            ->setMessage('The user does not own the provided location(s)');
    }

    /**
     * @param mixed|Value $value
     * @return Error|null
     */
    public function check($value)
    {
        if (is_array($value)){
            if (!$this->userService->hasLocations($this->owner->getId(), $value)){
                return $this->getError();
            }
        } else {
            if (!$this->userService->hasLocation($this->owner->getId(), $value)){
                return $this->getError();
            }
        }

        return null;
    }
}