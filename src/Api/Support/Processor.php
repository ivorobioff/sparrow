<?php
namespace ImmediateSolutions\Api\Support;
use ImmediateSolutions\Support\Api\AbstractProcessor;
use ImmediateSolutions\Support\Validation\Source\ClearableAwareInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class Processor extends AbstractProcessor
{
    /**
     * @param $object
     * @param $property
     * @param callable $modifier
     */
    protected function set($object, $property, callable $modifier = null)
    {
        if (!$this->has($property)){
            return ;
        }

        $accessor = PropertyAccess::createPropertyAccessor();

        $value = $this->get($property);

        if ($modifier !== null){
            $value = $modifier($value);
        }


        $accessor->setValue($object, $property, $value);

        if ($value === null && $object instanceof ClearableAwareInterface){
            $object->addClearable($property);
        }
    }
}