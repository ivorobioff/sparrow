<?php
namespace ImmediateSolutions\Api\User\Controllers;

use ImmediateSolutions\Api\User\Processors\UsersProcessor;
use ImmediateSolutions\Api\User\Serializers\UserSerializer;
use ImmediateSolutions\Core\User\Services\UserService;
use ImmediateSolutions\Support\Api\AbstractController;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class UsersController extends AbstractController
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @param UserService $userService
     */
    public function initialize(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param UsersProcessor $processor
     * @return ResponseInterface
     */
    public function store(UsersProcessor $processor)
    {
        return $this->reply->single(
            $this->userService->create($processor->createPayload()),
            $this->serializer(UserSerializer::class)
        );
    }

    /**
     * @param int $userId
     * @return ResponseInterface
     */
    public function show($userId)
    {
        $user = $this->userService->get($userId);

        if (!$user){
            $this->show404();
        }

        return $this->reply->single($user, $this->serializer(UserSerializer::class));
    }

    /**
     * @param int $userId
     * @param UsersProcessor $processor
     * @return ResponseInterface
     */
    public function update($userId, UsersProcessor $processor)
    {
        if (!$this->userService->exists($userId)){
            $this->show404();
        }

        $this->userService->update($userId,  $processor->createPayload());

        return $this->reply->blank();
    }

    /**
     * @param int $userId
     * @return ResponseInterface
     */
    public function destroy($userId)
    {
        if (!$this->userService->exists($userId)){
            $this->show404();
        }

        $this->userService->delete($userId);

        return $this->reply->blank();
    }
}