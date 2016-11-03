<?php
namespace ImmediateSolutions\Infrastructure\Session;
use ImmediateSolutions\Core\Session\Interfaces\TokenGeneratorInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class TokenGenerator implements TokenGeneratorInterface
{
    /**
     * @return string
     */
    public function generate()
    {
        return md5(uniqid(rand(), true));
    }
}