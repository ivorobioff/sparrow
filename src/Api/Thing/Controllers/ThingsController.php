<?php
namespace ImmediateSolutions\Api\Thing\Controllers;
use ImmediateSolutions\Api\Support\Controller;
use ImmediateSolutions\Api\Thing\Processors\ThingsProcessor;
use ImmediateSolutions\Api\Thing\Processors\ThingsSearchableProcessor;
use ImmediateSolutions\Api\Thing\Serializers\ThingSerializer;
use ImmediateSolutions\Core\Thing\Options\FetchThingsOptions;
use ImmediateSolutions\Core\Thing\Services\ThingService;
use ImmediateSolutions\Support\Api\DefaultPaginatorAdapter;
use ImmediateSolutions\Support\Core\Options\PaginationOptions;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ThingsController extends Controller
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
     * @param $thingId
     * @return ResponseInterface
     */
    public function show($thingId)
    {
        return $this->reply->single(
            $this->thingService->get($thingId),
            $this->serializer(ThingSerializer::class)
        );
    }

    /**
     * @param ThingsSearchableProcessor $processor
     * @return ResponseInterface
     */
    public function index(ThingsSearchableProcessor $processor)
    {
        $adapter = new DefaultPaginatorAdapter([
            'getAll' => function($page, $perPage) use ($processor){

                $options = new FetchThingsOptions();

                $options->setPagination(new PaginationOptions($page, $perPage));
                $options->setCriteria($processor->getCriteria());
                $options->setSortables($processor->createSortables());

                return $this->thingService
                    ->getAll($this->session->getUser()->getId(), $options);
            },
            'getTotal' => function() use ($processor){
                return $this->thingService->getTotal(
                    $this->session->getUser()->getId(),
                    $processor->getCriteria()
                );
            }
        ]);

        return $this->reply->collection(
            $this->paginator($adapter),
            $this->serializer(ThingSerializer::class)
        );
    }

    /**
     * @param ThingsProcessor $processor
     * @return ResponseInterface
     */
    public function store(ThingsProcessor $processor)
    {
        $thing = $this->thingService->create(
            $this->session->getUser()->getId(),
            $processor->createPayload()
        );

        return $this->reply->single($thing, $this->serializer(ThingSerializer::class));
    }

    /**
     * @param int $thingId
     * @param ThingsProcessor $processor
     * @return ResponseInterface
     */
    public function update($thingId, ThingsProcessor $processor)
    {
        $this->thingService->update($thingId, $processor->createPayload());

        return $this->reply->blank();
    }

    /**
     * @param int $thingId
     * @return ResponseInterface
     */
    public function destroy($thingId)
    {
        $this->thingService->delete($thingId);

        return $this->reply->blank();
    }
}