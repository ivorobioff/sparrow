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
     * @param int $id
     * @return Thing
     */
    public function get($id)
    {
        return new Thing();
    }

    /**
     * @param int $userId
     * @return Thing[]
     */
    public function getAll($userId)
    {
        return [];
    }

    /**
     * @param ThingPayload $payload
     * @return Thing
     */
    public function create(ThingPayload $payload)
    {
        $thing = new Thing();
        $thing->setName($payload->getName());

        $this->entityManager->persist($thing);
        $this->entityManager->flush();

        return $thing;
    }
}