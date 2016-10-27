<?php
namespace ImmediateSolutions\Support\Web;
use ImmediateSolutions\Support\Framework\MiddlewareInterface;
use Psr\Http\Message\RequestInterface;
use ImmediateSolutions\Support\Framework\Exceptions\AbstractHttpException;
use Zend\Diactoros\Response;

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
        try {
            $response = $next($request);
        } catch (AbstractHttpException $ex){
            $response = new Response();
            $response->getBody()->write('Oh shit.. the error just happened.');
        }

        return $response;
    }
}