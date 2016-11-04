<?php
namespace ImmediateSolutions\Api\Thing\Serializers;
use ImmediateSolutions\Api\Support\Serializer;
use ImmediateSolutions\Core\Thing\Entities\Category;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CategorySerializer extends Serializer
{
    /**
     * @param Category $category
     * @return array
     */
    public function __invoke(Category $category)
    {
        return [
            'id' => $category->getId(),
            'title' => $category->getTitle(),
            'children' => array_map(function(Category $category){
                return $this->delegate(CategorySerializer::class, $category);
            }, iterator_to_array($category->getChildren()))
        ];
    }
}