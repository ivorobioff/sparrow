<?php
namespace ImmediateSolutions\Core\Document\Entities;

use DateTime;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Document
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
    private $token;
    public function setToken($token) { $this->token = $token; }
    public function getToken() { return $this->token; }

    /**
     * @var string
     */
    private $name;
    public function setName($name) { $this->name = $name; }
    public function getName() { return $this->name; }

    /**
     * @var int
     */
    private $size;
    public function setSize($size) { $this->size = $size; }
    public function getSize() { return $this->size; }

    /**
     * @var string
     */
    private $format;
    public function setFormat($format) { $this->format = $format; }
    public function getFormat() { return $this->format; }

    /**
     * @var string
     */
    private $uri;
    public function setUri($uri) { $this->uri = $uri; }
    public function getUri() { return $this->uri; }

    /**
     * @var DateTime
     */
    private $uploadedAt;
    public function setUploadedAt(DateTime $datetime) { $this->uploadedAt = $datetime; }
    public function getUploadedAt() { return $this->uploadedAt; }

    private $usage = 0;
    public function increaseUsage() { $this->usage ++; }
    public function decreaseUsage() { $this->usage --; }

    public function __construct()
    {
        $this->setUploadedAt(new DateTime());
    }
}