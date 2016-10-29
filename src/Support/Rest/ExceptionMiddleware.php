<?php
namespace ImmediateSolutions\Support\Rest;

use ImmediateSolutions\Support\Framework\Exceptions\AbstractHttpException;
use ImmediateSolutions\Support\Framework\MiddlewareInterface;
use Psr\Http\Message\RequestInterface;
use Exception;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ExceptionMiddleware implements MiddlewareInterface
{
    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    /**
     * @param RequestInterface $request
     * @param callable $next
     * @return mixed
     */
    public function handle(RequestInterface $request, callable $next)
    {
        try {
            $response = $next($request);
        } catch (AbstractHttpException $ex) {
            $response = $this->writeHttpException($ex);
        } catch(Exception $exception) {
            $response = $this->writeException(500, 'Internal Server Error');
        }

        return $response;
    }

    /**
     * @param AbstractHttpException $exception
     * @return ResponseInterface
     */
    private function writeHttpException(AbstractHttpException $exception)
    {
        return $this->writeException($exception->getCode(), $exception->getMessage());
    }

    /**
     * @param int $code
     * @param string $message
     * @return ResponseInterface
     */
    private function writeException($code, $message)
    {
        return $this->responseFactory->create([
            'code' => $code,
            'message' => $message
        ], $code);
    }
}