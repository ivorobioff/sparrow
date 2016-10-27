<?php
namespace ImmediateSolutions\Support\Framework;
use ImmediateSolutions\Support\Framework\Exceptions\ImmutableValueException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Request implements RequestInterface
{
    /**
     * @var Source
     */
    private $source;

    /**
     * @param RequestInterface $source
     */
    public function __construct(RequestInterface $source)
    {
        $this->source = $source;
    }

    /**
     * @return string
     */
    public function getProtocolVersion()
    {
        return $this->source->getProtocolVersion();
    }

    public function withProtocolVersion($version)
    {
        $this->throwImmutableValueException();
    }

    /**
     * @return string[][]
     */
    public function getHeaders()
    {
        return $this->source->getHeaders();
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasHeader($name)
    {
        return $this->source->hasHeader($name);
    }

    /**
     * @param string $name
     * @return string[]
     */
    public function getHeader($name)
    {
        return $this->source->getHeader($name);
    }

    /**
     * @param string $name
     * @return string
     */
    public function getHeaderLine($name)
    {
        return $this->source->getHeaderLine($name);
    }

    public function withHeader($name, $value)
    {
        $this->throwImmutableValueException();
    }

    public function withAddedHeader($name, $value)
    {
        $this->throwImmutableValueException();
    }

    public function withoutHeader($name)
    {
        $this->throwImmutableValueException();
    }

    /**
     * @return StreamInterface
     */
    public function getBody()
    {
        return $this->source->getBody();
    }

    public function withBody(StreamInterface $body)
    {
        $this->throwImmutableValueException();
    }

    /**
     * @return string
     */
    public function getRequestTarget()
    {
        return $this->source->getRequestTarget();
    }

    public function withRequestTarget($requestTarget)
    {
        $this->throwImmutableValueException();
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->source->getMethod();
    }

    public function withMethod($method)
    {
        $this->throwImmutableValueException();
    }

    /**
     * @return UriInterface
     */
    public function getUri()
    {
        return $this->source->getUri();
    }

    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        $this->throwImmutableValueException();
    }

    /**
     * @param RequestInterface $source
     */
    public function setSource(RequestInterface $source)
    {
        $this->source = $source;
    }

    private function throwImmutableValueException()
    {
        throw new ImmutableValueException('This request object is immutable. You have to replace the source of this object via the "setSource" method.');
    }
}