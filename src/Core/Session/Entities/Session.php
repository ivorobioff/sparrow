<?php
namespace ImmediateSolutions\Core\Session\Entities;

use DateTime;
use ImmediateSolutions\Core\User\Entities\User;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Session
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
     * @var User
     */
    private $user;
    public function setUser(User $user) { $this->user = $user; }
    public function getUser() { return $this->user; }

    /**
     * @var DateTime
     */
    private $createdAt;
    public function setCreatedAt(DateTime $datetime) { $this->createdAt = $datetime; }
    public function getCreatedAt() { return $this->createdAt; }

    /**
     * @var DateTime
     */
    private $expiresAt;
    public function setExpiresAt(DateTime $datetime) { $this->expiresAt = $datetime; }
    public function getExpiresAt() { return $this->expiresAt; }

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
    }
}