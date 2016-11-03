<?php
namespace ImmediateSolutions\Core\User\Entities;

use DateTime;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class User
{
    /**
     * @var
     */
    private $id;
    public function setId($id) { $this->id = $id; }
    public function getId() { return $this->id; }

    /**
     * @var string
     */
    private $email;
    public function setEmail($email) { $this->email = trim($email); }
    public function getEmail() { return $this->email; }

    /**
     * @var string
     */
    private $password;
    public function setPassword($password) { $this->password = $password; }
    public function getPassword() { return $this->password; }

    /**
     * @var string
     */
    private $firstName;
    public function setFirstName($firstName) { $this->firstName = $firstName; }
    public function getFirstName() { return $this->firstName; }

    /**
     * @var string
     */
    private $lastName;
    public function setLastName($lastName) { $this->lastName = $lastName; }
    public function getLastName() { return $this->lastName; }

    /**
     * @var DateTime
     */
    private $createdAt;
    public function setCreatedAt(DateTime $datetime){ $this->createdAt = $datetime; }
    public function getCreatedAt() { return $this->createdAt; }

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
    }
}