<?php
namespace ImmediateSolutions\Api\Session\Controllers;
use ImmediateSolutions\Api\Session\Processors\CredentialsProcessor;
use ImmediateSolutions\Api\Session\Serializers\SessionSerializer;
use ImmediateSolutions\Api\Support\Controller;
use ImmediateSolutions\Core\Session\Services\SessionService;
use ImmediateSolutions\Core\User\Services\UserService;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class SessionsController extends Controller
{
    /**
     * @var SessionService
     */
    private $sessionService;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @param SessionService $sessionService
     */
    public function initialize(SessionService $sessionService, UserService $userService)
    {
        $this->sessionService = $sessionService;
        $this->userService = $userService;
    }

    /**
     * @param CredentialsProcessor $processor
     * @return ResponseInterface
     */
    public function store(CredentialsProcessor $processor)
    {
        $session = $this->sessionService->create($processor->createPayload());

        return $this->reply->single($session, $this->serializer(SessionSerializer::class));
    }

    /**
     * @param $sessionId
     * @return ResponseInterface
     */
    public function refresh($sessionId)
    {
        $session = $this->sessionService->refresh($sessionId);

        return $this->reply->single($session, $this->serializer(SessionSerializer::class));
    }

    /**
     * @param int $sessionId
     * @return ResponseInterface
     */
    public function show($sessionId)
    {
        $session = $this->sessionService->get($sessionId);

        return $this->reply->single($session, $this->serializer(SessionSerializer::class));
    }

    /**
     * @param int $sessionId
     * @return ResponseInterface
     */
    public function destroy($sessionId)
    {
        $this->sessionService->delete($sessionId);

        return $this->reply->blank();
    }
}