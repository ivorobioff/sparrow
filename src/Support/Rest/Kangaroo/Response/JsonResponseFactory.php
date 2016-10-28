<?php
namespace ImmediateSolutions\Support\Rest\Kangaroo\Response;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class JsonResponseFactory implements ResponseFactoryInterface
{
    /**
     * @param string $content
     * @param string $status
     * @return ResponseInterface
     */
    public function create($content, $status)
    {
        return new Response(json_encode($content), $status, ['Content-Type' => 'application/json']);
    }
}