<?php
namespace ImmediateSolutions\Core\Session\Interfaces;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface TokenGeneratorInterface
{
    /**
     * @return string
     */
    public function generate();
}