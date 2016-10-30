<?php
namespace ImmediateSolutions\Support\Core\Options;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface PropertiesToClearInterface
{
    /**
     * @param array $properties
     * @return $this
     */
    public function setPropertiesToClear(array $properties);

    /**
     * @param string $property
     * @return bool
     */
    public function isPropertyToClear($property);

    /**
     * @return array
     */
    public function getPropertiesToClear();
}