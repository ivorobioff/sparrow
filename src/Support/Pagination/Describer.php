<?php
namespace ImmediateSolutions\Support\Pagination;
use Psr\Http\Message\RequestInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Describer implements DescriberInterface
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @return int
     */
    public function getCurrentPage()
    {
        parse_str($this->request->getUri()->getQuery(), $query);

        $page = array_get($query, 'page', 1);

        return (is_numeric($page) && $page > 0) ? (int) $page : 1;
    }

    /**
     * @return int
     */
    public function getPerPage()
    {
        parse_str($this->request->getUri()->getQuery(), $query);

        $perPage = array_get($query, 'perPage', 10);

        return (is_numeric($perPage) && $perPage > 0) ? (int) $perPage : 10;
    }
}