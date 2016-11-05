<?php
namespace ImmediateSolutions\Api\Thing\Serializers;
use ImmediateSolutions\Api\Document\Serializers\DocumentSerializer;
use ImmediateSolutions\Api\Support\Serializer;
use ImmediateSolutions\Core\Thing\Entities\Location;
use ImmediateSolutions\Core\Thing\Entities\Thing;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ThingSerializer extends Serializer
{
    public function __invoke(Thing $thing)
    {
        $data = [
            'id' => $thing->getId(),
            'name' => $thing->getName(),
            'description' => $thing->getDescription(),
            'attitude' => (string) $thing->getAttitude(),
            'rate' => $thing->getRate(),
            'locations' => array_map(function(Location $location){
                return $this->delegate(LocationSerializer::class, $location);
            }, iterator_to_array($thing->getLocations())),
            'createdAt' => $this->datetime($thing->getCreatedAt())
        ];

        if ($category = $thing->getCategory()){
            $category = $this->delegate(CategorySerializer::class, $category);
        }

        $data['category'] = $category;

        if ($image = $thing->getImage()){
            $image = $this->delegate(DocumentSerializer::class, $image);
        }

        $data['image'] = $image;

        return $data;
    }
}