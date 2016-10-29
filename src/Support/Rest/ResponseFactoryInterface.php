<?php
namespace ImmediateSolutions\Support\Rest;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface ResponseFactoryInterface
{
    /**
     * @param mixed $content
     * @param int $status
     * @return ResponseInterface
     */
    public function create($content, $status);
}