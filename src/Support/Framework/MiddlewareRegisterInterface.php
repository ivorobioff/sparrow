<?php
namespace ImmediateSolutions\Support\Framework;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface MiddlewareRegisterInterface
{
    /**
     * @param MiddlewareProcessor $processor
     */
    public function register(MiddlewareProcessor $processor);
}