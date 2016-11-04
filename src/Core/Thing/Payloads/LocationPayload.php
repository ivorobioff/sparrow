<?php
namespace ImmediateSolutions\Core\Thing\Payloads;
use ImmediateSolutions\Support\Core\Validation\ClearableAwareTrait;
use ImmediateSolutions\Support\Validation\Source\ClearableAwareInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class LocationPayload implements ClearableAwareInterface
{
    use ClearableAwareTrait;

    /**
     * @var string
     */
    private $name;
    public function setName($name) { $this->name = $name; }
    public function getName() { return $this->name; }

    /**
     * @var string
     */
    private $description;
    public function setDescription($description) { $this->description = $description; }
    public function getDescription() { return $this->description; }
}