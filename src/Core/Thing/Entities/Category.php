<?php
namespace ImmediateSolutions\Core\Thing\Entities;
use Doctrine\Common\Collections\ArrayCollection;
use ImmediateSolutions\Core\User\Entities\User;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Category
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
    private $title;
    public function setTitle($title) { $this->title = $title; }
    public function getTitle() { return $this->title; }

    /**
     * @var User
     */
    private $user;
    public function setUser(User $user) { $this->user = $user; }
    public function getUser() { return $this->user; }

    /**
     * @var Category
     */
    private $parent;
    public function getParent() { return $this->parent; }

    /**
     * @param Category $parent
     */
    public function setParent(Category $parent = null)
    {
        if ($parent === null && $this->parent){
            $this->parent->removeChild($this);
        }

        if ($parent !== null){

            if ($this->parent === null){
                $parent->addChild($this);
            } elseif ($this->parent->getId() != $parent->getId()) {
                $this->parent->removeChild($this);
                $parent->addChild($this);
            }
        }

        $this->parent = $parent;
    }

    /**
     * @var Category[]|ArrayCollection
     */
    private $children;
    public function getChildren() { return $this->children; }
    public function addChild(Category $category) { $this->children->add($category); }
    public function removeChild(Category $category) { $this->children->removeElement($category); }

    public function __construct()
    {
        $this->children = new ArrayCollection();
    }
}