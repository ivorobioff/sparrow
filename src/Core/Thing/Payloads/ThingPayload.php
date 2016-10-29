<?php
namespace ImmediateSolutions\Core\Thing\Payloads;
/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ThingPayload
{
    /**
     * @var string
     */
    private $name;
    public function setName($name) { $this->name = $name; }
    public function getName() { return $this->name; }
}