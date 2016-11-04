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
class OwnCategory extends AbstractRule
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var User
     */
    private $owner;

    public function __construct(UserService $userService, User $owner)
    {
        $this->userService = $userService;
        $this->owner = $owner;

        $this
            ->setIdentifier('permission')
            ->setMessage('The user does not own the provided category');
    }

    /**
     * @param mixed|Value $value
     * @return Error|null
     */
    public function check($value)
    {
        if (!$this->userService->hasCategory($this->owner->getId(), $value)){
            return $this->getError();
        }

        return null;
    }
}