<?php
namespace ImmediateSolutions\Support\Validation\Source;

use ImmediateSolutions\Support\Validation\SourceHandlerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ObjectSourceHandler implements SourceHandlerInterface
{
	/**
	 * @var object
	 */
	private $object;

	/**
	 * @var array
	 */
	private $forcedProperties;

	/**
	 * @param object $object
	 * @param array $forcedProperties
	 */
	public function __construct($object, array $forcedProperties = [])
	{
		$this->object = $object;
		$this->forcedProperties = $forcedProperties;
	}

	/**
	 * @return object
	 */
	public function getSource()
	{
		return $this->object;
	}

	/**
	 * @param string $property
	 * @return mixed
	 */
	public function getValue($property)
	{
        return PropertyAccess::createPropertyAccessor()
            ->getValue($this->object, $property);
    }

	/**
	 * @param string $property
	 * @return bool
	 */
	public function hasProperty($property)
	{
		return $this->getValue($property) !== null || in_array($property, $this->forcedProperties);
	}

	/**
	 * @param string $property
	 */
	public function addForcedProperty($property)
	{
		$this->forcedProperties[] = $property;
	}

	/**
	 * @return array
	 */
	public function getForcedProperties()
	{
		return $this->forcedProperties;
	}
}