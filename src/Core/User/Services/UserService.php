<?php
namespace ImmediateSolutions\Core\User\Services;
use ImmediateSolutions\Core\Support\Service;
use ImmediateSolutions\Core\User\Entities\User;
use ImmediateSolutions\Core\User\Interfaces\PasswordEncryptorInterface;
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
}