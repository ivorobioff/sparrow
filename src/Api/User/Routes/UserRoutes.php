<?php
namespace ImmediateSolutions\Api\User\Routes;
use ImmediateSolutions\Api\User\Controllers\UsersController;
use ImmediateSolutions\Support\Framework\RouterInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class UserRoutes
{
    public function __invoke(RouterInterface $router)
    {
        $router->post('/users', UsersController::class.'@store');
        $router->get('/users/{userId:\d+}', UsersController::class.'@show');
        $router->patch('/users/{userId:\d+}', UsersController::class.'@update');
        $router->delete('/users/{userId:\d+}', UsersController::class.'@destroy');
    }
}