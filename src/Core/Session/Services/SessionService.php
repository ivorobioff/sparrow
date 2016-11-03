<?php
namespace ImmediateSolutions\Core\Session\Services;
use ImmediateSolutions\Core\Session\Entities\Session;
use ImmediateSolutions\Core\Session\Interfaces\SessionPreferenceInterface;
use ImmediateSolutions\Core\Session\Interfaces\TokenGeneratorInterface;
use ImmediateSolutions\Core\User\Payloads\CredentialsPayload;
use ImmediateSolutions\Core\User\Validation\CredentialsValidator;
use ImmediateSolutions\Core\Support\Service;
use ImmediateSolutions\Core\User\Services\UserService;
use ImmediateSolutions\Support\Validation\PresentableException;
use DateTime;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class SessionService extends Service
{
    /**
     * @param CredentialsPayload $payload
     * @return Session
     */
    public function create(CredentialsPayload $payload)
    {
        $session = new Session();

        /**
         * @var UserService $userService
         */
        $userService = $this->container->get(UserService::class);

        (new CredentialsValidator($userService))->validate($payload);

        $session->setUser($userService->getAuthorized($payload));

        /**
         * @var SessionPreferenceInterface $preference
         */
        $preference = $this->container->get(SessionPreferenceInterface::class);

        $expiresAt = clone $session->getCreatedAt();
        $expiresAt->modify('+'.$preference->getLifeTime().' minutes');

        $session->setExpiresAt($expiresAt);

        /**
         * @var TokenGeneratorInterface $generator
         */
        $generator = $this->container->get(TokenGeneratorInterface::class);

        $session->setToken($generator->generate());

        $this->entityManager->persist($session);
        $this->entityManager->flush();

        return $session;
    }

    /**
     * @param int $id
     * @return Session
     */
    public function refresh($id)
    {
        /**
         * @var Session $session
         */
        $session = $this->entityManager->find(Session::class, $id);

        if (!$session){
            throw new PresentableException('Session not found');
        }

        /**
         * @var TokenGeneratorInterface $generator
         */
        $generator = $this->container->get(TokenGeneratorInterface::class);

        $session->setToken($generator->generate());

        /**
         * @var SessionPreferenceInterface $preference
         */
        $preference = $this->container->get(SessionPreferenceInterface::class);

        $expiresAt = clone $session->getExpiresAt();
        $expiresAt->modify('+'.$preference->getLifeTime().' minutes');

        $session->setExpiresAt($expiresAt);

        $this->entityManager->flush();

        return $session;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function exists($id)
    {
        return $this->entityManager->getRepository(Session::class)->exists(['id' => $id]);
    }

    /**
     * @param int $id
     * @return Session
     */
    public function get($id)
    {
        return $this->entityManager->find(Session::class, $id);
    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
        $this->entityManager->getRepository(Session::class)->delete(['id' => $id]);
    }

    /**
     * @param string $token
     * @return Session
     */
    public function getByToken($token)
    {
        return $this->entityManager->getRepository(Session::class)->findOneBy(['token' => $token]);
    }
}