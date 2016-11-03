<?php
namespace ImmediateSolutions\Api\User\Processors;
use ImmediateSolutions\Api\Support\Processor;
use ImmediateSolutions\Core\User\Payloads\UserPayload;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class UsersProcessor extends Processor
{
    /**
     * @return array
     */
    public function schema()
    {
        return [
            'email' => 'string',
            'password' => 'string',
            'firstName' => 'string',
            'lastName' => 'string'
        ];
    }

    /**
     * @return UserPayload
     */
    public function createPayload()
    {
        $payload = new UserPayload();

        $this->set($payload, 'email');
        $this->set($payload, 'password');
        $this->set($payload, 'firstName');
        $this->set($payload, 'lastName');

        return $payload;
    }
}