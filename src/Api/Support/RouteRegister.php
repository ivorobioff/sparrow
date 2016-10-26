<?php
namespace ImmediateSolutions\Api\Support;
use ImmediateSolutions\Api\Thing\Controllers\ThingsController;
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
        $router->get('/things', ThingsController::class.'@index');
    }
}