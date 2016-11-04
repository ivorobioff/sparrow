<?php
namespace ImmediateSolutions\Core\Thing\Services;

use ImmediateSolutions\Support\Core\Service\AbstractService;
use ImmediateSolutions\Core\Thing\Entities\Thing;
use ImmediateSolutions\Core\Thing\Payloads\ThingPayload;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ThingService extends AbstractService
{
    /**
     * @param ThingPayload $payload
     * @return Thing
     */
    public function create(ThingPayload $payload)
    {
        $thing = new Thing();



        $this->entityManager->persist($thing);
        $this->entityManager->flush();

        return $thing;
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
     * @return Thing[]
     */
    public function getAll($userId)
    {
        return $this->entityManager->getRepository(Thing::class)->findAll();
    }
}