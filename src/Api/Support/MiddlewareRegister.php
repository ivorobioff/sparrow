<?php
namespace ImmediateSolutions\Api\Support;
use ImmediateSolutions\Support\Framework\MiddlewarePipeline;
use ImmediateSolutions\Support\Framework\MiddlewareRegisterInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class MiddlewareRegister implements MiddlewareRegisterInterface
{
    /**
     * @param MiddlewarePipeline $pipeline
     */
    public function register(MiddlewarePipeline $pipeline)
    {
        //
    }
}