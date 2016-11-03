<?php
namespace ImmediateSolutions\Api\Session\Controllers;
use ImmediateSolutions\Api\Session\Processors\CredentialsProcessor;
use ImmediateSolutions\Api\Session\Serializers\SessionSerializer;
use ImmediateSolutions\Api\Support\Controller;
use ImmediateSolutions\Core\Session\Services\SessionService;
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
     * @param SessionService $sessionService
     */
    public function initialize(SessionService $sessionService)
    {
        $this->sessionService = $sessionService;
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
        if (!$this->sessionService->exists($sessionId)){
            $this->show404();
        }

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

        if (!$session){
            $this->show404();
        }

        return $this->reply->single($session, $this->serializer(SessionSerializer::class));
    }

    /**
     * @param int $sessionId
     * @return ResponseInterface
     */
    public function destroy($sessionId)
    {
        if (!$this->sessionService->exists($sessionId)){
            $this->show404();
        }

        $this->sessionService->delete($sessionId);

        return $this->reply->blank();
    }
}