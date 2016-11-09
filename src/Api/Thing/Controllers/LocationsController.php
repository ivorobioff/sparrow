<?php
namespace ImmediateSolutions\Api\Thing\Controllers;
use ImmediateSolutions\Api\Support\Controller;
use ImmediateSolutions\Api\Thing\Processors\LocationsProcessor;
use ImmediateSolutions\Api\Thing\Processors\LocationsSearchableProcessor;
use ImmediateSolutions\Api\Thing\Serializers\LocationSerializer;
use ImmediateSolutions\Core\Thing\Options\FetchLocationsOptions;
use ImmediateSolutions\Core\Thing\Services\LocationService;
use ImmediateSolutions\Core\User\Services\UserService;
use ImmediateSolutions\Support\Api\DefaultPaginatorAdapter;
use ImmediateSolutions\Support\Core\Options\PaginationOptions;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class LocationsController extends Controller
{
    /**
     * @var LocationService
     */
    private $locationService;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @param LocationService $locationService
     * @param UserService $userService
     */
    public function initialize(LocationService $locationService, UserService $userService)
    {
        $this->locationService = $locationService;
        $this->userService = $userService;
    }

    /**
     * @param LocationsSearchableProcessor $processor
     * @return ResponseInterface
     */
    public function index(LocationsSearchableProcessor $processor)
    {
        $adapter = new DefaultPaginatorAdapter([
            'getAll' => function($page, $perPage) use ($processor){

                $options = new FetchLocationsOptions();

                $options->setPagination(new PaginationOptions($page, $perPage));
                $options->setCriteria($processor->getCriteria());
                $options->setSortables($processor->createSortables());

                return $this->locationService
                    ->getAll($this->session->getUser()->getId(), $options);
            },
            'getTotal' => function() use ($processor){
                return $this->locationService->getTotal(
                    $this->session->getUser()->getId(),
                    $processor->getCriteria()
                );
            }
        ]);

        return $this->reply->collection(
            $this->paginator($adapter),
            $this->serializer(LocationSerializer::class)
        );
    }

    /**
     * @param LocationsProcessor $processor
     * @return ResponseInterface
     */
    public function store(LocationsProcessor $processor)
    {
        $location = $this->locationService->create(
            $this->session->getUser()->getId(),
            $processor->createPayload()
        );

        return $this->reply->single($location, $this->serializer(LocationSerializer::class));
    }

    /**
     * @param int $locationId
     * @param LocationsProcessor $processor
     * @return ResponseInterface
     */
    public function update($locationId, LocationsProcessor $processor)
    {
        $this->locationService->update($locationId, $processor->createPayload());

        return $this->reply->blank();
    }

    /**
     * @param int $locationId
     * @return ResponseInterface
     */
    public function show($locationId)
    {
        $location = $this->locationService->get($locationId);

        return $this->reply->single($location, $this->serializer(LocationSerializer::class));
    }

    /**
     * @param int $locationId
     * @return ResponseInterface
     */
    public function destroy($locationId)
    {
        $this->locationService->delete($locationId);

        return $this->reply->blank();
    }
}