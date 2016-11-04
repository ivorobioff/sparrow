<?php
namespace ImmediateSolutions\Support\Framework;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface DispatcherInterface
{
    /**
     * @param ServerRequestInterface $request
     */
    public function dispatch(ServerRequestInterface $request);
}