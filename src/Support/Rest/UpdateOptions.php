<?php
namespace ImmediateSolutions\Support\Rest;
use ImmediateSolutions\Support\Core\Options\PropertiesToClearInterface;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class UpdateOptions implements PropertiesToClearInterface
{
    /**
     * @var array
     */
    private $propertiesToClear = [];

    /**
     * @param array $properties
     * @return $this
     */
    public function setPropertiesToClear(array $properties)
    {
        $this->propertiesToClear = $properties;
        return $this;
    }

	/**
	 * @param string $property
	 * @return bool
	 */
	public function isPropertyToClear($property)
	{
		return in_array($property, $this->propertiesToClear);
	}

	/**
	 * @return array
	 */
    public function getPropertiesToClear()
    {
        return $this->propertiesToClear;
    }
}