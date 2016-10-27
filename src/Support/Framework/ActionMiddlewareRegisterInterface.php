<?php
namespace ImmediateSolutions\Support\Framework;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface ActionMiddlewareRegisterInterface
{
    public function register(MiddlewarePipeline $pipeline);
}