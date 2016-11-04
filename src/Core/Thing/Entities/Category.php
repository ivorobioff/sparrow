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
     * @param Category $category
     */
    public function setParent(Category $category)
    {
        $this->parent = $category;
        $category->addChildren($this);
    }

    /**
     * @var Category[]|ArrayCollection
     */
    private $children;
    public function getChildren() { return $this->children; }
    public function addChildren(Category $category) { $this->children->add($category); }

    public function __construct()
    {
        $this->children = new ArrayCollection();
    }
}