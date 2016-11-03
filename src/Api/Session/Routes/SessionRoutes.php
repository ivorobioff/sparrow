<?php
namespace ImmediateSolutions\Api\Session\Routes;
use ImmediateSolutions\Api\Session\Controllers\SessionsController;
use ImmediateSolutions\Support\Framework\RouterInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class SessionRoutes
{
    public function __invoke(RouterInterface $router)
    {
        $router->post('/sessions', SessionsController::class.'@store');
        $router->post('/sessions/{sessionId:\d+}/refresh', SessionsController::class.'@refresh');
        $router->get('/sessions/{sessionId:\d+}', SessionsController::class.'@show');
        $router->delete('/sessions/{sessionId:\d+}', SessionsController::class.'@destroy');
    }
}