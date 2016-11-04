<?php
namespace ImmediateSolutions\Api\Thing\Routes;
use ImmediateSolutions\Api\Thing\Controllers\CategoriesController;
use ImmediateSolutions\Support\Framework\RouterInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CategoryRoutes
{
    /**
     * @param RouterInterface $router
     */
    public function __invoke(RouterInterface $router)
    {
        $router->get('/categories', CategoriesController::class.'@index');
        $router->post('/categories', CategoriesController::class.'@store');
        $router->get('/categories/{categoryId:\d+}', CategoriesController::class.'@show');
        $router->patch('/categories/{categoryId:\d+}', CategoriesController::class.'@update');
        $router->delete('/categories/{categoryId:\d+}', CategoriesController::class.'@destroy');
    }
}