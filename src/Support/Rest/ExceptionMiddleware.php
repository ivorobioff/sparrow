<?php
namespace ImmediateSolutions\Support\Rest;
use ImmediateSolutions\Support\Framework\MiddlewareInterface;
use Psr\Http\Message\RequestInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ExceptionMiddleware implements MiddlewareInterface
{
    /**
     * @param RequestInterface $request
     * @param callable $next
     * @return mixed
     */
    public function handle(RequestInterface $request, callable $next)
    {
        // TODO: Implement handle() method.
    }
}