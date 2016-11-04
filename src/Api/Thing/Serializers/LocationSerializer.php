<?php
namespace ImmediateSolutions\Api\Thing\Serializers;
use ImmediateSolutions\Api\Support\Serializer;
use ImmediateSolutions\Core\Thing\Entities\Location;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class LocationSerializer extends Serializer
{
    public function __invoke(Location $location)
    {
        return [
            'id' => $location->getId(),
            'name' => $location->getName(),
            'description' => $location->getDescription()
        ];
    }
}