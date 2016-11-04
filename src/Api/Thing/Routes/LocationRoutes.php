<?php
namespace ImmediateSolutions\Api\Thing\Routes;
use ImmediateSolutions\Api\Thing\Controllers\LocationsController;
use ImmediateSolutions\Support\Framework\RouterInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class LocationRoutes
{
    /**
     * @param RouterInterface $router
     */
    public function __invoke(RouterInterface $router)
    {
        $router->get('/locations', LocationsController::class.'@index');
        $router->post('/locations', LocationsController::class.'@store');
        $router->patch('/locations/{locationId:\d+}', LocationsController::class.'@update');
        $router->get('/locations/{locationId:\d+}', LocationsController::class.'@show');
        $router->delete('/locations/{locationId:\d+}', LocationsController::class.'@destroy');
    }
}