<?php
namespace ImmediateSolutions\Support\Rest\Kangaroo\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface ResponseFactoryInterface
{
    /**
     * @param string $content
     * @param string $status
     * @return ResponseInterface
     */
    public function create($content, $status);
}