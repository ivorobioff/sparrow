<?php
namespace ImmediateSolutions\Core\Thing\Payloads;
use ImmediateSolutions\Core\Document\Payloads\IdentifierPayload;
use ImmediateSolutions\Core\Thing\Enums\Attitude;
use ImmediateSolutions\Support\Core\Validation\ClearableAwareTrait;
use ImmediateSolutions\Support\Validation\Source\ClearableAwareInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ThingPayload implements ClearableAwareInterface
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
     * @var IdentifierPayload
     */
    private $image;
    public function setImage(IdentifierPayload $identifier = null) { $this->image = $identifier; }
    public function getImage() { return $this->image; }

    /**
     * @var int
     */
    private $category;
    public function setCategory($category) { $this->category = $category; }
    public function getCategory() { return $this->category; }

    /**
     * @var array
     */
    private $locations = [];
    public function setLocations(array $locations) { $this->locations = $locations; }
    public function getLocations() { return $this->locations; }
}