<?php
namespace ImmediateSolutions\Support\Framework;
use Psr\Http\Message\RequestInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface DispatcherInterface
{
    /**
     * @param RequestInterface $request
     */
    public function dispatch(RequestInterface $request);
}