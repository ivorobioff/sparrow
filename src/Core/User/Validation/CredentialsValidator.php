<?php
namespace ImmediateSolutions\Core\User\Validation;
use ImmediateSolutions\Core\User\Services\UserService;
use ImmediateSolutions\Core\User\Validation\Rules\Access;
use ImmediateSolutions\Support\Validation\AbstractThrowableValidator;
use ImmediateSolutions\Support\Validation\Binder;
use ImmediateSolutions\Support\Validation\Property;
use ImmediateSolutions\Support\Validation\Rules\Obligate;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CredentialsValidator extends AbstractThrowableValidator
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param Binder $binder
     * @return void
     */
    protected function define(Binder $binder)
    {
        $binder->bind('email', function(Property $property){
            $property->addRule(new Obligate());
        });

        $binder->bind('password', function(Property $property){
            $property->addRule(new Obligate());
        });

        $binder->bind('credentials', ['email', 'password'], function(Property $property){
            $property->addRule(new Access($this->userService));
        });
    }
}