<?php
namespace ImmediateSolutions\Api\Support;
use ImmediateSolutions\Api\Document\Routes\DocumentRoutes;
use ImmediateSolutions\Api\Session\Routes\SessionRoutes;
use ImmediateSolutions\Api\Thing\Routes\CategoryRoutes;
use ImmediateSolutions\Api\Thing\Routes\LocationRoutes;
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
        call_user_func(new SessionRoutes(), $router);
        call_user_func(new DocumentRoutes(), $router);
        call_user_func(new LocationRoutes(), $router);
        call_user_func(new CategoryRoutes(), $router);
    }
}