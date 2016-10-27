<?php
namespace ImmediateSolutions\Support\Framework;
use Psr\Http\Message\RequestInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface MiddlewareInterface
{
    /**
     * @param RequestInterface $request
     * @param callable $next
     * @return mixed
     */
    public function handle(RequestInterface $request, callable $next);
}