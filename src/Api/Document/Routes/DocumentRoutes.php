<?php
namespace ImmediateSolutions\Api\Document\Routes;
use ImmediateSolutions\Api\Document\Controllers\DocumentsController;
use ImmediateSolutions\Support\Framework\RouterInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DocumentRoutes
{
    public function __invoke(RouterInterface $router)
    {
        $router->post('/documents', DocumentsController::class.'@store');
    }
}