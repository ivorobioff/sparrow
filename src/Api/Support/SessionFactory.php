<?php
namespace ImmediateSolutions\Api\Support;
use ImmediateSolutions\Core\Session\Entities\Session;
use ImmediateSolutions\Core\Session\Services\SessionService;
use ImmediateSolutions\Support\Framework\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class SessionFactory
{
    /**
     * @param ContainerInterface $container
     * @return Session
     */
    public function __invoke(ContainerInterface $container)
    {
        /**
         * @var ServerRequestInterface $request
         */
        $request = $container->get(ServerRequestInterface::class);

        $token = $request->getHeader('Token')[0] ?? null;

        if (!$token){
            return new Session();
        }

        /**
         * @var SessionService $sessionService
         */
        $sessionService = $container->get(SessionService::class);

        return ($sessionService->getNotExpiredByToken($token) ?? new Session());
    }
}