<?php
namespace ImmediateSolutions\Api\Thing\Routes;
use ImmediateSolutions\Api\Thing\Controllers\ThingsController;
use ImmediateSolutions\Support\Framework\RouterInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ThingRoutes
{
    /**
     * @param RouterInterface $router
     */
    public function __invoke(RouterInterface $router)
    {
        $router->get('/things', ThingsController::class.'@index');
        $router->post('/things', ThingsController::class.'@store');
        $router->patch('/things/{thingId:\d+}', ThingsController::class.'@update');
        $router->get('/things/{thingId:\d+}', ThingsController::class.'@show');
        $router->delete('/things/{thingId:\d+}', ThingsController::class.'@destroy');
    }
}