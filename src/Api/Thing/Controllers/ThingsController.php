<?php
namespace ImmediateSolutions\Api\Thing\Controllers;
use ImmediateSolutions\Api\Thing\Processors\ThingsProcessor;
use ImmediateSolutions\Api\Thing\Serializers\ThingSerializer;
use ImmediateSolutions\Core\Thing\Services\ThingService;
use ImmediateSolutions\Support\Rest\AbstractController;
use Psr\Http\Message\ResponseInterface;

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
     * @param $id
     * @return ResponseInterface
     */
    public function show($id)
    {
        return $this->reply->single(
            $this->thingService->get($id),
            $this->serializer(ThingSerializer::class)
        );
    }

    /**
     * @return ResponseInterface
     */
    public function index()
    {
        return $this->reply->collection(
            $this->thingService->getAll(10),
            $this->serializer(ThingSerializer::class)
        );
    }

    /**
     * @param ThingsProcessor $processor
     * @return ResponseInterface
     */
    public function store(ThingsProcessor $processor)
    {
        $thing = $this->thingService->create($processor->createPayload());

        return $this->reply->single($thing, $this->serializer(ThingSerializer::class));
    }
}