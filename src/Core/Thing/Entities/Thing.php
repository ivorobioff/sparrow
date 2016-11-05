<?php
namespace ImmediateSolutions\Core\Thing\Entities;
use Doctrine\Common\Collections\ArrayCollection;
use ImmediateSolutions\Core\Document\Entities\Document;
use ImmediateSolutions\Core\Document\Support\DocumentUsageManagementTrait;
use ImmediateSolutions\Core\Thing\Enums\Attitude;
use DateTime;
use ImmediateSolutions\Core\User\Entities\User;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Thing
{
    use DocumentUsageManagementTrait;

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

    /**
     * @var string
     */
    private $description;
    public function setDescription($description) { $this->description = $description; }
    public function getDescription() { return $this->description; }

    /**
     * @var Attitude
     */
    private $attitude;
    public function setAttitude(Attitude $attitude)  { $this->attitude = $attitude; }
    public function getAttitude() { return $this->attitude; }

    /**
     * @var int
     */
    private $rate;
    public function setRate($rate) { $this->rate = $rate; }
    public function getRate() { return $this->rate; }

    /**
     * @var Document
     */
    private $image;
    public function getImage() { return $this->image; }

    /**
     * @param Document $document
     */
    public function setImage(Document $document = null)
    {
        $this->handleUsageOfOneDocument($this->getImage(), $document);
        $this->image = $document;
    }

    private $category;
    public function setCategory(Category $category = null) { $this->category = $category; }
    public function getCategory()  { return $this->category; }

    /**
     * @var Location[]|ArrayCollection
     */
    private $locations;
    public function getLocations() { return $this->locations; }

    /**
     * @param Location[] $locations
     */
    public function setLocations(array $locations)
    {
        $this->locations->clear();

        foreach ($locations as $location){
            $this->locations->add($location);
        }
    }

    /**
     * @var DateTime
     */
    private $createdAt;
    public function setCreatedAt(DateTime $datetime) { $this->createdAt = $datetime; }
    public function getCreatedAt() { return $this->createdAt; }

    /**
     * @var User
     */
    private $user;
    public function setUser(User $user) { $this->user = $user; }
    public function getUser() { return $this->user; }

    public function __construct()
    {
        $this->locations = new ArrayCollection();
        $this->setCreatedAt(new DateTime());
    }
}