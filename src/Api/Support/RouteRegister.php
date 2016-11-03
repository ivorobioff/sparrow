<?php
namespace ImmediateSolutions\Api\Support;
use ImmediateSolutions\Api\User\Routes\UserRoutes;
use ImmediateSolutions\Support\Framework\RouteRegisterInterface;
use ImmediateSolutions\Support\Framework\RouterInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class RouteRegister implements RouteRegisterInterface
{
    /**
     * @param RouterInterface $router
     */
    public function register(RouterInterface $router)
    {
        call_user_func(new UserRoutes(), $router);
    }
}