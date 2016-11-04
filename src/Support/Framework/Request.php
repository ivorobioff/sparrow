<?php
namespace ImmediateSolutions\Support\Framework;
use ImmediateSolutions\Support\Framework\Exceptions\ImmutableValueException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Request implements ServerRequestInterface
{
    /**
     * @var ServerRequestInterface
     */
    private $source;

    /**
     * @param ServerRequestInterface $source
     */
    public function __construct(ServerRequestInterface $source)
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
     * @param ServerRequestInterface $source
     */
    public function setSource(ServerRequestInterface $source)
    {
        $this->source = $source;
    }

    private function throwImmutableValueException()
    {
        throw new ImmutableValueException('This request object is immutable. You have to replace the source of this object via the "setSource" method.');
    }

    /**
     * @return array
     */
    public function getServerParams()
    {
        return $this->source->getServerParams();
    }

    /**
     * @return array
     */
    public function getCookieParams()
    {
        return $this->source->getServerParams();
    }

    /**
     * @param array $cookies Array of key/value pairs representing cookies.
     * @return static
     */
    public function withCookieParams(array $cookies)
    {
        $this->throwImmutableValueException();
    }

    /**
     * @return array
     */
    public function getQueryParams()
    {
        return $this->source->getQueryParams();
    }

    /**
     * @param array $query Array of query string arguments, typically from
     *     $_GET.
     * @return static
     */
    public function withQueryParams(array $query)
    {
        $this->throwImmutableValueException();
    }

    /**
     * @return array An array tree of UploadedFileInterface instances; an empty
     *     array MUST be returned if no data is present.
     */
    public function getUploadedFiles()
    {
        return $this->source->getUploadedFiles();
    }

    /**
     * @param array $uploadedFiles An array tree of UploadedFileInterface instances.
     * @return static
     * @throws \InvalidArgumentException if an invalid structure is provided.
     */
    public function withUploadedFiles(array $uploadedFiles)
    {
        $this->throwImmutableValueException();
    }

    /**
     * @return null|array|object The deserialized body parameters, if any.
     *     These will typically be an array or object.
     */
    public function getParsedBody()
    {
        return $this->source->getParsedBody();
    }

    /**
     * @param null|array|object $data The deserialized body data. This will
     *     typically be in an array or object.
     * @return static
     * @throws \InvalidArgumentException if an unsupported argument type is
     *     provided.
     */
    public function withParsedBody($data)
    {
        $this->throwImmutableValueException();
    }

    /**
     * @return array Attributes derived from the request.
     */
    public function getAttributes()
    {
        return $this->source->getAttributes();
    }

    /**
     * @param string $name The attribute name.
     * @param mixed $default Default value to return if the attribute does not exist.
     * @return mixed
     */
    public function getAttribute($name, $default = null)
    {
        return $this->source->getAttribute($name, $default);
    }

    /**
     * @param string $name The attribute name.
     * @param mixed $value The value of the attribute.
     * @return static
     */
    public function withAttribute($name, $value)
    {
        $this->throwImmutableValueException();
    }

    /**
     * @param string $name The attribute name.
     * @return static
     */
    public function withoutAttribute($name)
    {
        $this->throwImmutableValueException();
    }
}