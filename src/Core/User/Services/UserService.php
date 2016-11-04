<?php
namespace ImmediateSolutions\Core\User\Services;
use ImmediateSolutions\Core\Session\Entities\Session;
use ImmediateSolutions\Core\Support\Service;
use ImmediateSolutions\Core\Thing\Entities\Category;
use ImmediateSolutions\Core\Thing\Entities\Location;
use ImmediateSolutions\Core\User\Entities\User;
use ImmediateSolutions\Core\User\Interfaces\PasswordEncryptorInterface;
use ImmediateSolutions\Core\User\Payloads\CredentialsPayload;
use ImmediateSolutions\Core\User\Payloads\UserPayload;
use ImmediateSolutions\Core\User\Validation\UserValidator;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class UserService extends Service
{
    /**
     * @param UserPayload $payload
     * @return User
     */
    public function create(UserPayload $payload)
    {
        (new UserValidator($this))->validate($payload);

        $user = new User();

        $this->exchange($payload, $user);

        $this->entityManager->persist($user);

        $this->entityManager->flush();

        return $user;
    }

    /**
     * @param int $id
     * @param UserPayload $payload
     */
    public function update($id, UserPayload $payload)
    {
        /**
         * @var User $user
         */
        $user = $this->entityManager->find(User::class, $id);

        (new UserValidator($this, $user))->validate($payload, true);

        $this->exchange($payload, $user);

        $this->entityManager->flush();
    }

    /**
     * @param UserPayload $payload
     * @param User $user
     */
    private function exchange(UserPayload $payload, User $user)
    {
        $this->transfer($payload, $user, 'email');
        $this->transfer($payload, $user, 'firstName');
        $this->transfer($payload, $user, 'lastName');

        $this->transfer($payload, $user, 'password', function($password){
            /**
             * @var PasswordEncryptorInterface $encryptor
             */
            $encryptor = $this->container->get(PasswordEncryptorInterface::class);

            return $encryptor->encrypt($password);
        });
    }

    /**
     * @param int $id
     * @return  User
     */
    public function get($id)
    {
        return $this->entityManager->find(User::class, $id);
    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
        $this->entityManager->getRepository(User::class)->delete(['id' => $id]);
    }

    /**
     * @param $id
     * @return bool
     */
    public function exists($id)
    {
        return $this->entityManager
            ->getRepository(User::class)
            ->exists(['id' => $id]);
    }

    /**
     * @param string $email
     * @return bool
     */
    public function existsByEmail($email)
    {
        return $this->entityManager
            ->getRepository(User::class)
            ->exists(['email' => trim($email)]);
    }

    /**
     * @param CredentialsPayload $payload
     * @return bool
     */
    public function canAuthorize(CredentialsPayload $payload)
    {
        return (bool) $this->getAuthorized($payload);
    }

    /**
     * @param CredentialsPayload $payload
     * @return User
     */
    public function getAuthorized(CredentialsPayload $payload)
    {
        /**
         * @var User $user
         */
        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => $payload->getEmail()]);

        if (!$user){
            return null;
        }

        /**
         * @var PasswordEncryptorInterface $encryptor
         */
        $encryptor = $this->container->get(PasswordEncryptorInterface::class);

        if (!$encryptor->verify($payload->getPassword(), $user->getPassword())){
            return null;
        }

        return $user;
    }

    /**
     * @param int $userId
     * @param int $sessionId
     * @return bool
     */
    public function hasSession($userId, $sessionId)
    {
        return $this->entityManager->getRepository(Session::class)
            ->exists(['user' => $userId, 'id' => $sessionId]);
    }

    /**
     * @param int $userId
     * @param int $locationId
     * @return bool
     */
    public function hasLocation($userId, $locationId)
    {
        return $this->entityManager->getRepository(Location::class)
            ->exists(['user' => $userId, 'id' => $locationId]);
    }


    /**
     * @param int $userId
     * @param int $categoryId
     * @return bool
     */
    public function hasCategory($userId, $categoryId)
    {
        return $this->entityManager->getRepository(Category::class)
            ->exists(['user' => $userId, 'id' => $categoryId]);
    }
}