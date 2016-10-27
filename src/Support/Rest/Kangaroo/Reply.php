<?php
namespace ImmediateSolutions\Support\Rest\Kangaroo;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Reply
{
    /**
     * @return ResponseInterface
     */
    public function blank()
    {

    }

    /**
     * @param array $data
     * @return ResponseInterface
     */
    public function raw(array $data)
    {

    }

    /**
     * @param object $item
     * @param callable $serializer
     * @return ResponseInterface
     */
    public function single($item, callable $serializer)
    {

    }

    /**
     * @param object[] $items
     * @param callable $serializer
     * @return ResponseInterface
     */
    public function collection($items, callable $serializer)
    {

    }
}