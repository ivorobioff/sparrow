<?php
namespace ImmediateSolutions\Api\Thing\Controllers;
use ImmediateSolutions\Api\Thing\Processors\ThingsProcessor;
use ImmediateSolutions\Core\Thing\Services\ThingService;
use ImmediateSolutions\Support\Rest\AbstractController;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ThingsController extends AbstractController
{
    /**
     * @var ThingService
     */
    private $thingService;

    /**
     * @param ThingService $thingService
     */
    public function initialize(ThingService $thingService)
    {
        $this->thingService = $thingService;
    }

    /**
     * @param ThingsProcessor $processor
     */
    public function store(ThingsProcessor $processor)
    {
        $payload = $processor->createPayload();

        $thing = $this->thingService->create($payload);
    }
}