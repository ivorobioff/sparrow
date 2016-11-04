<?php
namespace ImmediateSolutions\Core\Thing\Entities;
use Doctrine\Common\Collections\ArrayCollection;
use ImmediateSolutions\Core\Document\Entities\Document;
use ImmediateSolutions\Core\Document\Entities\Support\DocumentUsageManagementTrait;
use ImmediateSolutions\Core\Thing\Enums\Attitude;
use DateTime;

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
    public function setImage(Document $document)
    {
        $this->handleUsageOfOneDocument($this->getImage(), $document);
        $this->image = $document;
    }

    private $category;
    public function setCategory(Category $category) { $this->category = $category; }
    public function getCategory()  { return $this->category; }

    /**
     * @var Location[]|ArrayCollection
     */
    private $locations;
    public function getLocations() { return $this->locations; }

    public function addLocation(Location $location)
    {
        $this->locations->add($location);
    }

    public function clearLocations()
    {
        $this->locations->clear();
    }


    /**
     * @var DateTime
     */
    private $createdAt;
    public function setCreatedAt(DateTime $datetime) { $this->createdAt = $datetime; }
    public function getCreatedAt() { return $this->createdAt; }

    public function __construct()
    {
        $this->locations = new ArrayCollection();
    }
}