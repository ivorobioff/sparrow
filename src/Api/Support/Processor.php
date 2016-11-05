<?php
namespace ImmediateSolutions\Api\Support;
use ImmediateSolutions\Core\Document\Payloads\IdentifierPayload;
use ImmediateSolutions\Core\Document\Payloads\IdentifiersPayload;
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

    /**
     * @param int|array $idOrData
     * @return IdentifierPayload
     */
    public function asDocument($idOrData)
    {
        if (is_array($idOrData)){
            return new IdentifierPayload($idOrData['id'], $idOrData['token']);
        }

        return new IdentifierPayload($idOrData);
    }

    /**
     * @param array $data
     * @return IdentifiersPayload
     */
    public function asDocuments(array $data)
    {
        $result = [];

        foreach ($data as $item){
            $result[] = $this->asDocument($data);
        }

        return $result;
    }
}