<?php
namespace ImmediateSolutions\Api\Support;
use ImmediateSolutions\Core\Document\Payloads\IdentifierPayload;
use ImmediateSolutions\Support\Api\AbstractProcessor;
use ImmediateSolutions\Support\Validation\Source\ClearableAwareInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Closure;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class Processor extends AbstractProcessor
{
    /**
     * @param $object
     * @param $property
     * @param callable $modifier
     * @param bool $nullable
     */
    protected function set($object, $property, callable $modifier = null, $nullable = true)
    {
        if (!$this->has($property)){
            return ;
        }

        $accessor = PropertyAccess::createPropertyAccessor();

        $value = $this->get($property);

        if ($modifier !== null){
            $value = $modifier($value);
        }

        if ($nullable || $value !== null){
            $accessor->setValue($object, $property, $value);
        }

        if ($nullable && $value === null && $object instanceof ClearableAwareInterface){
            $object->addClearable($property);
        }
    }

    /**
     * @return Closure
     */
    public function asDocument()
    {
        return function($value){
            if ($value === null){
                return null;
            }

            if (is_array($value)){
                return new IdentifierPayload($value['id'], $value['token']);
            }

            return new IdentifierPayload($value);
        };
    }

    /**
     * @return Closure
     */
    public function asDocuments()
    {
        return function($data) {

            if ($data === null){
                return null;
            }

            return array_map($this->asDocument(), $data);
        };
    }

    /**
     * @param $class
     * @return Closure
     */
    protected function asEnum($class)
    {
        return function($value) use ($class){
            if ($value === null){
                return null;
            }

            return new $class($value);
        };
    }
}