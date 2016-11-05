<?php
namespace ImmediateSolutions\Core\Thing\Services;

use ImmediateSolutions\Core\Document\Entities\Document;
use ImmediateSolutions\Core\Document\Payloads\IdentifierPayload;
use ImmediateSolutions\Core\Support\Service;
use ImmediateSolutions\Core\Thing\Criteria\ThingFilterResolver;
use ImmediateSolutions\Core\Thing\Criteria\ThingSorterResolver;
use ImmediateSolutions\Core\Thing\Entities\Category;
use ImmediateSolutions\Core\Thing\Entities\Location;
use ImmediateSolutions\Core\Thing\Options\FetchThingsOptions;
use ImmediateSolutions\Core\Thing\Validation\ThingValidator;
use ImmediateSolutions\Core\User\Entities\User;
use ImmediateSolutions\Core\Thing\Entities\Thing;
use ImmediateSolutions\Core\Thing\Payloads\ThingPayload;
use ImmediateSolutions\Support\Core\Criteria\Filter;
use ImmediateSolutions\Support\Core\Criteria\Paginator;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ThingService extends Service
{
    /**
     * @param int $userId
     * @param ThingPayload $payload
     * @return Thing
     */
    public function create($userId, ThingPayload $payload)
    {
        /**
         * @var User $user
         */
        $user = $this->entityManager->getReference(User::class, $userId);

        (new ThingValidator($this->container, $user))->validate($payload);

        $thing = new Thing();

        $this->exchange($payload, $thing);

        $thing->setUser($user);

        $this->entityManager->persist($thing);
        $this->entityManager->flush();

        return $thing;
    }

    /**
     * @param int $id
     * @param ThingPayload $payload
     */
    public function update($id, ThingPayload $payload)
    {
        /**
         * @var Thing $thing
         */
        $thing = $this->entityManager->find(Thing::class, $id);

        (new ThingValidator($this->container, $thing))->validate($payload, true);

        $this->exchange($payload, $thing);

        $this->entityManager->flush();
    }

    /**
     * @param ThingPayload $payload
     * @param Thing $thing
     */
    private function exchange(ThingPayload $payload, Thing $thing)
    {
        $this->transfer($payload, $thing, 'name');
        $this->transfer($payload, $thing, 'description');
        $this->transfer($payload, $thing, 'attitude');
        $this->transfer($payload, $thing, 'rate');
        $this->transfer($payload, $thing, 'image', function(IdentifierPayload $payload = null){

            if ($payload == null){
                return null;
            }

            return $this->entityManager->getReference(Document::class, $payload->getId());
        });

        $this->transfer($payload, $thing, 'locations', function(array $ids){
            return array_map(function($id){
                return $this->entityManager->getReference(Location::class, $id);
            }, $ids);
        });

        $this->transfer($payload, $thing, 'category', function($id){

            if ($id === null){
                return null;
            }

            return $this->entityManager->getReference(Category::class, $id);
        });
    }


    /**
     * @param int $id
     * @return Thing
     */
    public function get($id)
    {
        return $this->entityManager->find(Thing::class, $id);
    }

    /**
     * @param int $userId
     * @param FetchThingsOptions $options
     * @return Thing[]
     */
    public function getAll($userId, FetchThingsOptions $options = null)
    {
        if ($options === null){
            $options = new FetchThingsOptions();
        }

        $builder = $this->entityManager->createQueryBuilder();

        $builder->from(Thing::class, 't')->select('t');

        $builder
            ->andWhere($builder->expr()->eq('t.user', ':user'))
            ->setParameter('user', $userId);

        (new Filter())->apply($builder, $options->getCriteria(), new ThingFilterResolver())
            ->withSorter($builder, $options->getSortables(), new ThingSorterResolver());

        return (new Paginator())->apply($builder, $options->getPagination());
    }

    /**
     * @param int $userId
     * @param array $criteria
     * @return int
     */
    public function getTotal($userId, array $criteria = [])
    {
        $builder = $this->entityManager->createQueryBuilder();

        $builder->from(Thing::class, 't')
            ->select($builder->expr()->countDistinct('t'));

        $builder
            ->andWhere($builder->expr()->eq('t.user', ':user'))
            ->setParameter('user', $userId);

        (new Filter())->apply($builder, $criteria, new ThingFilterResolver());

        return (int) $builder->getQuery()->getSingleScalarResult();
    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
        /**
         * @var Thing $thing
         */
        $thing = $this->entityManager->find(Thing::class, $id);
        $thing->setImage(null);
        $this->entityManager->remove($thing);
        $this->entityManager->flush();
    }
}