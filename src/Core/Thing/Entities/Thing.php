<?php
namespace ImmediateSolutions\Core\Thing\Entities;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Thing
{
    /**
     * @var int
     */
    private $id;
    public function setId($id) { $this->id = $id; }
    public function getId() { return $this->id; }

    /**
     * @var string
     */
    private $name;
    public function setName($name) { $this->name = $name; }
    public function getName() { return $this->name; }
}