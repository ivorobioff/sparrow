<?php
namespace ImmediateSolutions\Support\Rest\Kangaroo;

use ImmediateSolutions\Support\Framework\HttpStatusCode;
use ImmediateSolutions\Support\Rest\Kangaroo\Response\ResponseFactoryInterface;
use ImmediateSolutions\Support\Validation\ErrorsThrowableCollection;
use ImmediateSolutions\Support\Validation\Fail;
use Psr\Http\Message\ResponseInterface;

/**
 * The class is used to output http errors.
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Error
{
    /**
     * @var ResponseFactoryInterface
     */
    private $responseFactory;

    /**
     * Predefined http error messages.
     *
     * @var array
     */
    private $messages = [
        HttpStatusCode::HTTP_NOT_FOUND => 'Not Found',
        HttpStatusCode::HTTP_BAD_REQUEST => 'Bad Request',
        HttpStatusCode::HTTP_FORBIDDEN => 'Forbidden',
        HttpStatusCode::HTTP_UNAUTHORIZED => 'Unauthorized',
        HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR => 'Internal Error'
    ];

    /**
     * @param ResponseFactoryInterface $responseFactory
     */
    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    /**
     * Outputs the "internal server error" http error
     * @param null|string $message
     * @return ResponseInterface
     */
    public function internal($message = null)
    {
        return $this->write(HttpStatusCode::HTTP_INTERNAL_SERVER_ERROR, $message);
    }

    /**
     * @param string|null $message
     * @return ResponseInterface
     */
    public function notFound($message = null)
    {
        if (!$message){
            $message = $this->messages[HttpStatusCode::HTTP_NOT_FOUND];
        }

        return $this->write(HttpStatusCode::HTTP_NOT_FOUND, $message);
    }

    /**
     * @param ErrorsThrowableCollection $errors
     * @return ResponseInterface
     */
    public function invalid(ErrorsThrowableCollection $errors)
    {
        $data = [];

        /**
         * @var Fail[] $e
         */
        foreach ($errors as $property => $error){
            $data[$property] = $this->prepareError($error);
        }

        return $this->responseFactory->create(['errors' => $data], HttpStatusCode::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @param Fail $fail
     * @return array
     */
    private function prepareError(Fail $fail)
    {
        $data = [
            'identifier' => $fail->getIdentifier(),
            'message' => $fail->getMessage(),
            'extra' => []
        ];

        if ($fail->hasExtra()){
            foreach ($fail->getExtra() as $name => $extra){
                $data['extra'][$name] = $this->prepareError($extra);
            }
        }

        return $data;
    }

    /**
     * Outputs http error with the provided message and status code.
     * @param string $message
     * @param int $status
     * @return ResponseInterface
     */
    public function write($status, $message = null)
    {
        if (!$message) {
            $message = array_get($this->messages, $status, 'Unknown Error');
        }

        $content = [
            'message' => $message,
            'code' => $status
        ];

        return $this->responseFactory->create($content, $status);
    }
}