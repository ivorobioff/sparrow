<?php
namespace ImmediateSolutions\Core\User\Validation\Rules;
use ImmediateSolutions\Core\User\Entities\User;
use ImmediateSolutions\Core\User\Services\UserService;
use ImmediateSolutions\Support\Validation\Error;
use ImmediateSolutions\Support\Validation\Rules\AbstractRule;
use ImmediateSolutions\Support\Validation\Value;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Unique extends AbstractRule
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var User
     */
    private $currentUser;

    /**
     * @param UserService $userService
     * @param User|null $currentUser
     */
    public function __construct(UserService $userService, User $currentUser = null)
    {
        $this->userService = $userService;
        $this->currentUser = $currentUser;

        $this
            ->setIdentifier('unique')
            ->setMessage('The user with the provided username already exists');
    }

    /**
     * @param mixed|Value $value
     * @return Error|null
     */
    public function check($value)
    {
        if ($this->currentUser && $this->currentUser->getEmail() === $value){
            return null;
        }

        if ($this->userService->existsByEmail($value)){
            return $this->getError();
        }

        return null;
    }
}