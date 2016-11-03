<?php
namespace ImmediateSolutions\Core\User\Validation\Rules;
use ImmediateSolutions\Core\User\Payloads\CredentialsPayload;
use ImmediateSolutions\Core\User\Services\UserService;
use ImmediateSolutions\Support\Validation\Error;
use ImmediateSolutions\Support\Validation\Rules\AbstractRule;
use ImmediateSolutions\Support\Validation\Value;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Access extends AbstractRule
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

        $this
            ->setIdentifier('access')
            ->setMessage('A user with the provided credentials cannot be found.');
    }

    /**
     * @param Value $value
     * @return Error|null
     */
    public function check($value)
    {
        list($email, $password) = $value->extract();

        $payload = new CredentialsPayload();
        $payload->setEmail($email);
        $payload->setPassword($password);

        if ($this->userService->canAuthorize($payload)){
            return null;
        }

        return $this->getError();
    }
}