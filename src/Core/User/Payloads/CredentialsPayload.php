<?php
namespace ImmediateSolutions\Core\User\Payloads;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CredentialsPayload
{
    /**
     * @var string
     */
    private $email;
    public function setEmail($email) { $this->email = $email; }
    public function getEmail() { return $this->email; }

    /**
     * @var string
     */
    private $password;
    public function setPassword($password) { $this->password = $password; }
    public function getPassword() { return $this->password; }
}