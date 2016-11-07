<?php
namespace ImmediateSolutions\Web\Support;
use ImmediateSolutions\Support\Framework\RouteRegisterInterface;
use ImmediateSolutions\Support\Framework\RouterInterface;
use ImmediateSolutions\Web\Controllers\IndexController;

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
        $router->get('/api', IndexController::class.'@api');
        $router->get('{uri:.*}', IndexController::class.'@index');
    }
}