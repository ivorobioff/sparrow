<?php
namespace ImmediateSolutions\Api\Thing\Serializers;
use ImmediateSolutions\Core\Thing\Entities\Thing;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ThingSerializer
{
    public function __invoke(Thing $thing)
    {
        return [
            'id' => $thing->getId(),
            'name' => $thing->getName()
        ];
    }
}