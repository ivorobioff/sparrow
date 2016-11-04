<?php
namespace ImmediateSolutions\Core\Thing\Payloads;
use ImmediateSolutions\Support\Core\Validation\ClearableAwareTrait;
use ImmediateSolutions\Support\Validation\Source\ClearableAwareInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CategoryPayload implements ClearableAwareInterface
{
    use ClearableAwareTrait;

    /**
     * @var string
     */
    private $title;
    public function setTitle($title) { $this->title = $title; }
    public function getTitle() { return $this->title; }

    /**
     * @var int
     */
    private $parent;
    public function setParent($category) { $this->parent = $category; }
    public function getParent() { return $this->parent; }
}