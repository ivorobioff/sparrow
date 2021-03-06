<?php
namespace ImmediateSolutions\Core\Thing\Services;
use ImmediateSolutions\Core\Support\Service;
use ImmediateSolutions\Core\Thing\Criteria\LocationFilterResolver;
use ImmediateSolutions\Core\Thing\Criteria\LocationSorterResolver;
use ImmediateSolutions\Core\Thing\Entities\Location;
use ImmediateSolutions\Core\Thing\Options\FetchLocationsOptions;
use ImmediateSolutions\Core\Thing\Payloads\LocationPayload;
use ImmediateSolutions\Core\Thing\Validation\LocationValidator;
use ImmediateSolutions\Core\User\Entities\User;
use ImmediateSolutions\Support\Core\Criteria\Criteria;
use ImmediateSolutions\Support\Core\Criteria\Filter;
use ImmediateSolutions\Support\Core\Criteria\Paginator;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class LocationService extends Service
{
    /**
     * @param int $userId
     * @param LocationPayload $payload
     * @return Location
     */
    public function create($userId, LocationPayload $payload)
    {
        $location = new Location();

        (new LocationValidator())->validate($payload);

        /**
         * @var User $user
         */
        $user = $this->entityManager->getReference(User::class, $userId);

        $location->setUser($user);

        $this->exchange($payload, $location);

        $this->entityManager->persist($location);
        $this->entityManager->flush();

        return $location;
    }

    /**
     * @param int $id
     * @param LocationPayload $payload
     */
    public function update($id, LocationPayload $payload)
    {
        (new LocationValidator())->validate($payload, true);

        /**
         * @var Location $location
         */
        $location = $this->entityManager->find(Location::class, $id);

        $this->exchange($payload, $location);

        $this->entityManager->flush();
    }

    /**
     * @param LocationPayload $payload
     * @param Location $location
     */
    private function exchange(LocationPayload $payload, Location $location)
    {
        $this->transfer($payload, $location, 'name');
        $this->transfer($payload, $location, 'description');
    }

    /**
     * @param int $id
     * @return Location
     */
    public function get($id)
    {
        return $this->entityManager->find(Location::class, $id);
    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
        $this->entityManager->getRepository(Location::class)->delete(['id' => $id]);
    }

    /**
     * @param int $userId
     * @param FetchLocationsOptions $options
     * @return Location[]
     */
    public function getAll($userId, FetchLocationsOptions $options = null)
    {
        if ($options === null){
            $options = new FetchLocationsOptions();
        }

        $builder = $this->entityManager->createQueryBuilder();

        $builder
            ->from(Location::class, 'l')
            ->select('l')
            ->andWhere($builder->expr()->eq('l.user', ':user'))
            ->setParameter('user', $userId);

        (new Filter())->apply($builder, $options->getCriteria(), new LocationFilterResolver())
            ->withSorter($builder, $options->getSortables(), new LocationSorterResolver());

        return (new Paginator())->apply($builder, $options->getPagination());
    }

    /**
     * @param int $userId
     * @param Criteria[] $criteria
     * @return int
     */
    public function getTotal($userId, array $criteria)
    {
        $builder = $this->entityManager->createQueryBuilder();

        $builder
            ->from(Location::class, 'l')
            ->select($builder->expr()->countDistinct('l'))
            ->andWhere($builder->expr()->eq('l.user', ':user'))
            ->setParameter('user', $userId);

        (new Filter())->apply($builder, $criteria, new LocationFilterResolver());

        return (int) $builder->getQuery()->getSingleScalarResult();
    }
}