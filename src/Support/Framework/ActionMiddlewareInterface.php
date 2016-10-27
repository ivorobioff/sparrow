<?php
namespace ImmediateSolutions\Support\Framework;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface ActionMiddlewareInterface
{
    /**
     * @param Action $action
     * @param callable $next
     * @return ResponseInterface
     */
    public function handle(Action $action, callable $next);
}