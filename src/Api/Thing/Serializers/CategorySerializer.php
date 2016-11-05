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
     * @var bool
     */
    private $withParent = true;

    /**
     * @var bool
     */
    private $withChildren = true;

    /**
     * @param Category $category
     * @return array
     */
    public function __invoke(Category $category)
    {
        $data = [
            'id' => $category->getId(),
            'title' => $category->getTitle()
        ];

        if ($this->withParent){
            if ($parent = $category->getParent()){

                $parent = $this->delegate(CategorySerializer::class, $parent, function(CategorySerializer $serializer){
                    $serializer->withChildren(false);
                });
            }

            $data['parent'] = $parent;
        }

        if ($this->withChildren){
            $data['children'] = array_map(function(Category $category){

                return $this->delegate(CategorySerializer::class, $category, function(CategorySerializer $serializer){
                    $serializer->withParent(false);
                });

            }, iterator_to_array($category->getChildren()));
        }

        return $data;
    }

    /**
     * @param bool $flag
     */
    public function withChildren($flag)
    {
        $this->withChildren = $flag;
    }

    /**
     * @param bool $flag
     */
    public function withParent($flag)
    {
        $this->withParent = $flag;
    }
}